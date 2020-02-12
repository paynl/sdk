<?php

declare(strict_types=1);

namespace PayNL\Sdk\Response;

use PayNL\Sdk\{Common\DebugAwareInterface,
    Common\DebugAwareTrait,
    Exception\InvalidArgumentException,
    Model\Error,
    Model\Errors,
    Transformer\TransformerAwareInterface,
    Transformer\TransformerAwareTrait};

/**
 * Class Response
 *
 * @package PayNL\Sdk
 */
class Response implements ResponseInterface, TransformerAwareInterface, DebugAwareInterface
{
    use TransformerAwareTrait, DebugAwareTrait;

    /**
     * @var string
     */
    protected $format = self::FORMAT_OBJECTS;

    /**
     * @var integer
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $rawBody;

    /**
     * @var mixed
     */
    protected $body;

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
     * @return Response
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param integer $statusCode
     *
     * @throws InvalidArgumentException when status code is not recognized
     *
     * @return Response
     */
    public function setStatusCode(int $statusCode): Response
    {
        if (false === array_key_exists($statusCode, self::HTTP_STATUS_CODES)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Status code "%s" is unavailable',
                    $statusCode
                )
            );
        }
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getRawBody(): string
    {
        return $this->rawBody;
    }

    /**
     * @param string $rawBody
     *
     * @return Response
     */
    public function setRawBody(string $rawBody): Response
    {

        $this->dumpDebugInfo('Raw response body: ' . $rawBody);

        $this->rawBody = $rawBody;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        if (true === empty($this->body) && true === array_key_exists($this->getStatusCode(), self::HTTP_STATUS_CODES)) {
            $this->body = self::HTTP_STATUS_CODES[$this->getStatusCode()];
        }
        return $this->body;
    }

    /**
     * @param mixed $body
     *
     * @return Response
     */
    public function setBody($body): Response
    {
        // initiate transformer (... more than meets the eye ;-) )
        if (static::FORMAT_OBJECTS === $this->getFormat()) {
            $body = $this->getTransformer()->transform($body);
        }

        $this->body = $body;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return (true === in_array($this->getStatusCode(), range(400, 599), true)
            || $this->getBody() instanceof Errors
        );
    }

    /**
     * Retrieve the current errors as a string for the request if there are any
     *
     * @return string
     */
    public function getErrors(): string
    {
        if (true === $this->hasErrors()) {
            $body = $this->getBody();
            if ($body instanceof Errors) {
                return implode("\n", $body->map(static function ($element) {
                    /** @var Error $element */
                    return sprintf(
                        '%s (%d)',
                        $element->getMessage(),
                        $element->getCode()
                    );
                })->toArray());
            }
            return $body;
        }
        return '';
    }
}
