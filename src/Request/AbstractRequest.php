<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Response;
use PayNL\Sdk\Transformer\Factory;

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
    protected $format = self::FORMAT_JSON;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var Client
     */
    protected $client;

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
     * @throws GuzzleException
     *
     * @return Response
     */
    public function execute(): Response
    {
        // create a Guzzle PSR 7 Request
        $guzzleRequest = new Request($this->getMethod(), $this->getUri(), $this->getHeaders());
        $guzzleResponse = $this->getClient()->send($guzzleRequest);

        $body = $guzzleResponse->getBody()->getContents();
//dump($body);
        // initiate transformer (... more than meets the eye ;-) )
        if (static::FORMAT_OBJECTS === $this->getFormat()) {
            $transformer = Factory::factory(static::class);
            $body = $transformer->transform($body);
        }

        return (new Response())
            ->setStatusCode($guzzleResponse->getStatusCode())
            ->setBody($body)
        ;
    }
}
