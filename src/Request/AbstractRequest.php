<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use RuntimeException;
use GuzzleHttp\{
    Client,
    Psr7\Request,
    Exception\RequestException,
    Exception\GuzzleException
};
use PayNL\Sdk\{DebugTrait,
    Exception\ExceptionInterface,
    Response,
    Exception\InvalidArgumentException,
    Filter\FilterInterface,
    Transformer\Factory,
    Transformer\Errors as ErrorsTransformer,
    Validator\ObjectInstance};
use Symfony\Component\Serializer\Encoder\{
    JsonEncoder,
    XmlEncoder
};

/**
 * Class AbstractRequest
 *
 * @package PayNL\Sdk\Request
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractRequest implements RequestInterface
{
    use DebugTrait;

    /**
     * @var string
     */
    protected $format = self::FORMAT_OBJECTS;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $body = '';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     *
     * @throws InvalidArgumentException when the given format is not valid
     *
     * @return AbstractRequest
     */
    public function setFormat(string $format): self
    {
        if (false === in_array($format, [self::FORMAT_OBJECTS, self::FORMAT_JSON, self::FORMAT_XML], true)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid format',
                    $format
                )
            );
        }
        $this->format = $format;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return AbstractRequest
     */
    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param array $headers
     *
     * @return AbstractRequest
     */
    public function setHeaders(array $headers): self
    {
        foreach ($headers as $name => $header) {
            $this->addHeader($name, $header);
        }
        return $this;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getHeader(string $name): ?string
    {
        if (false === array_key_exists($name, $this->getHeaders())) {
            return null;
        }
        return $this->headers[$name];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Automatically converts the given body to a string based
     * on the set format
     *
     * @param mixed $body
     *
     * @return AbstractRequest
     */
    public function setBody($body): self
    {
        if (false === is_string($body)) {
            $body = $this->encodeBody($body);
        }

        $this->body = $body;
        return $this;
    }

    /**
     * @param Client $client
     *
     * @return AbstractRequest
     */
    public function applyClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param string $name
     *
     * @return FilterInterface|null
     */
    public function getFilter(string $name): ?FilterInterface
    {
        if (false === array_key_exists($name, $this->filters)) {
            return null;
        }
        return $this->filters[$name];
    }

    /**
     * @param array $filters
     *
     * @throws InvalidArgumentException when the given filters contain an invalid filter
     *
     * @return AbstractRequest
     */
    public function setFilters(array $filters): self
    {
        // reset the filters
        $this->filters = [];

        $validator = new ObjectInstance();
        foreach ($filters as $filter) {
            if (false === $validator->isValid($filter, FilterInterface::class)) {
                throw new InvalidArgumentException(
                    implode(PHP_EOL, $validator->getMessages())
                );
            }
            $this->addFilter($filter);
        }
        return $this;
    }

    /**
     * @param FilterInterface $filter
     *
     * @return AbstractRequest
     */
    public function addFilter(FilterInterface $filter): self
    {
        $this->filters[$filter->getName()] = $filter;
        return $this;
    }

    /**
     * Automatically adds a Content-Type header
     *
     * @param mixed $body
     *
     * @return string
     */
    private function encodeBody($body): string
    {
        $encoder = new JsonEncoder();
        $contentTypeHeader = 'application/json';
        if (static::FORMAT_XML === $this->getFormat()) {
            $encoder = new XmlEncoder();
            $encoder->setRootNodeName('request');
            $contentTypeHeader = 'application/xml';
        }
        $this->addHeader(static::HEADER_CONTENT_TYPE, $contentTypeHeader);
        return (string)$encoder->encode($body, $this->getFormat());
    }

    /**
     * @param Response $response
     *
     * @return void
     */
    public function execute(Response $response): void
    {
        $uri = $this->getUri();
        $filters = $this->getFilters();
        if (0 < count($filters)) {
            $uri .= '?' . implode('&', $filters);
        }

        if (true === $this->isDebug()) {
            $this->dumpDebugInfo('Body: ' . $this->getBody());
        }

        // create a Guzzle PSR 7 Request
        $guzzleRequest = new Request($this->getMethod(), $uri, $this->getHeaders(), $this->getBody());
        if (true === $this->isDebug()) {
            $this->dumpDebugInfo('Requested URL: ' . $guzzleRequest->getUri());
        }

        try {
            $guzzleClient = $this->getClient();
            if (false === ($guzzleClient instanceof Client)) {
                throw new RuntimeException('No HTTP client found');
            }
            $guzzleResponse = $guzzleClient->send($guzzleRequest);

            $rawBody = $guzzleResponse->getBody()->getContents();

            $body = $rawBody;
            // initiate transformer (... more than meets the eye ;-) )
            if (static::FORMAT_OBJECTS === $this->getFormat()) {
                $transformer = Factory::getByRequestClassName(static::class);
                if (true === $this->isDebug()) {
                    $this->dumpDebugInfo('Use transformer: ' . get_class($transformer));
                }
                $body = $transformer->transform($rawBody);
            }

            $statusCode = $guzzleResponse->getStatusCode();

            if (true === $this->isDebug()) {
                $this->dumpDebugInfo('Response: ', $response);
            }
        } catch (RequestException $re) {
            $rawBody = $errorMessages = '';
            $body = $re->getMessage();
            if (true === method_exists($re, 'getResponse') && null !== $re->getResponse()) {
                $guzzleExceptionBody = $re->getResponse()->getBody();
                $size = $guzzleExceptionBody->isSeekable() === true ? $guzzleExceptionBody->getSize() : 0;

                if (0 < $size) {
                    $content = $guzzleExceptionBody->read($size);
                    $guzzleExceptionBody->rewind();

                    $errorMessages = $content;
                }

                $rawBody = trim($re->getResponse()->getReasonPhrase() . ': ' . $errorMessages, ': ');

                if ('' !== $errorMessages) {
                    $transformer = new ErrorsTransformer();
                    $body = $transformer->transform($errorMessages);
                }
            }

            $statusCode = $re->getCode();

        } catch (GuzzleException | ExceptionInterface $e) {
            $statusCode = $e->getCode() ?: 500;
            $rawBody = $e->getMessage();
            $body = $e->getMessage();
        } finally {
            $response->setStatusCode($statusCode)
                ->setRawBody($rawBody)
                ->setBody($body)
            ;
        }
    }
}
