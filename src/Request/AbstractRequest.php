<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Response;
use PayNL\Sdk\Transformer\Factory;
use PayNL\Sdk\Filter\FilterInterface;

/**
 * Class AbstractRequest
 *
 * @package PayNL\Sdk\Request
 */
abstract class AbstractRequest implements RequestInterface
{
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
     * @param mixed $value
     *
     * @return AbstractRequest
     */
    public function addHeader(string $name, $value): self
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
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getHeader(string $name): ?string
    {
        if (false === array_key_exists($name, $this->headers)) {
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
     * @param string $body
     *
     * @return AbstractRequest
     */
    public function setBody(string $body): self
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
    public function getClient(): Client
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
     * @return AbstractRequest
     */
    public function setFilters(array $filters): self
    {
        // "validate" the filters
        foreach ($filters as $filter) {
            if (false === ($filter instanceof FilterInterface)) {
                throw new InvalidArgumentException(
                    sprintf(
                        '%s is not an instance of %s',
                        is_object($filter) ? get_class($filter) : gettype($filter),
                        FilterInterface::class
                    )
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
     * @throws GuzzleException
     *
     * @param Response $response
     *
     * @return void
     */
    public function execute(Response $response): void
    {
        $uri = $this->getUri();
        $filters = $this->getFilters();
        if (0 < count($filters)) {
            $uri .= '?';
            foreach ($filters as $filter) {
                // TODO @Mike: sanitizing filter name and value?
                $uri .= $filter->getName() . '=' . $filter->getValue() . '&';
            }
            $uri = rtrim($uri, '&');
        }
dump($this->getBody());
        // create a Guzzle PSR 7 Request
        $guzzleRequest = new Request($this->getMethod(), $uri, $this->getHeaders(), $this->getBody());
dump((string)$guzzleRequest->getUri());
        $guzzleResponse = $this->getClient()->send($guzzleRequest);

        $rawBody = $guzzleResponse->getBody()->getContents();
        $body = $rawBody;
        // initiate transformer (... more than meets the eye ;-) )
        if (static::FORMAT_OBJECTS === $this->getFormat()) {
            $transformer = Factory::factory(static::class);
            $body = $transformer->transform($rawBody);
        }

        // TODO: is a hydrator necessary?
        $response->setStatusCode($guzzleResponse->getStatusCode())
            ->setRawBody($rawBody)
            ->setBody($body)
        ;
        dump($response);die;
    }
}
