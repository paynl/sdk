<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\GuzzleHttp\{
    Client,
    Psr7\Request,
    Exception\RequestException,
    Exception\GuzzleException
};
use PayNL\Sdk\{
    Common\DebugAwareInterface,
    Common\DebugAwareTrait,
    Exception\ExceptionInterface,
    Exception\RuntimeException,
    Response\Response,
    Exception\InvalidArgumentException,
    Filter\FilterInterface,
    Transformer\Manager as TransformerManager,
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
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractRequest implements RequestInterface, DebugAwareInterface
{
    use DebugAwareTrait;

    /*
     * Tag name declaration for XML request string
     */
    public const XML_ROOT_NODE_NAME = 'request';

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
     * @var TransformerManager
     */
    protected $transformerManager;

    public function __construct(TransformerManager $transformerManager)
    {
        $this->transformerManager = $transformerManager;
    }

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
    public function setHeader(string $name, string $value): self
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
            $this->setHeader($name, $header);
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
        if (false === is_string($this->body)) {
            return $this->encodeBody($this->body);
        }
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
        $context = [
            'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | (true === $this->isDebug() ? JSON_PRETTY_PRINT : 0),
        ];

        if (static::FORMAT_XML === $this->getFormat()) {
            $encoder = new XmlEncoder([
                XmlEncoder::ROOT_NODE_NAME => static::XML_ROOT_NODE_NAME,
            ]);
            $contentTypeHeader = 'application/xml';
            $context = [];
        }
        $this->setHeader(static::HEADER_CONTENT_TYPE, $contentTypeHeader);

        return (string)$encoder->encode($body, $this->getFormat(), $context);
    }

    /**
     * @param Response $response
     *
     * @throws RuntimeException when no HTTP client is set
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
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
                throw new RuntimeException('No HTTP client found', 500);
            }
            $guzzleResponse = $guzzleClient->send($guzzleRequest);

            $rawBody = $guzzleResponse->getBody()->getContents();

            $body = $rawBody;
            $statusCode = $guzzleResponse->getStatusCode();
        } catch (RequestException $re) {
            $rawBody = $errorMessages = '';
            $body = $re->getMessage();
            if (true === method_exists($re, 'getResponse') && null !== $re->getResponse()) {
                $guzzleExceptionBody = $re->getResponse()->getBody();
                $size = $guzzleExceptionBody->isSeekable() === true ? (int)$guzzleExceptionBody->getSize() : 0;

                if (0 < $size) {
                    $content = $guzzleExceptionBody->read($size);
                    $guzzleExceptionBody->rewind();

                    $errorMessages = $content;
                }

                $rawBody = trim($re->getResponse()->getReasonPhrase() . ': ' . $errorMessages, ': ');

                $body = $rawBody;

                if ('' !== $errorMessages && static::FORMAT_OBJECTS === $this->getFormat()) {
                    $transformer = $this->transformerManager->get('errors');
                    $body = $transformer->transform($errorMessages);
                }
            }

            $statusCode = $re->getCode();
        } catch (GuzzleException | ExceptionInterface $e) {
            $statusCode = $e->getCode() ?? 500;
            $rawBody = $e->getMessage();
            $body = 'Error: ' . $e->getMessage() . ' (' . $statusCode . ')';

            if (static::FORMAT_OBJECTS === $this->getFormat()) {
                die('adjust');
                $transformer = $this->transformerManager->get('errors');
                $body = $transformer->transform((new JsonEncoder())->encode([
                    'errors' => (object)[
                        'general' => (object)[
                            'code'    => $statusCode,
                            'message' => $rawBody,
                        ]
                    ]
                ], JsonEncoder::FORMAT));
            }
        }

        $response->setStatusCode($statusCode)
            ->setRawBody($rawBody)
            ->setBody($body)
        ;

        if (true === $this->isDebug()) {
            $this->dumpDebugInfo('Response: ', $response);
        }
    }
}
