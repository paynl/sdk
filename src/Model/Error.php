<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Error
 *
 * @package PayNL\Sdk\Model
 */
class Error implements ModelInterface
{
    /**
     * A reference to the response field
     *
     * @var string
     */
    protected $context;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @return string
     */
    public function getContext(): string
    {
        return (string)$this->context;
    }

    /**
     * @param string $context
     *
     * @return Error
     */
    public function setContext(string $context): self
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code ?? 0;
    }

    /**
     * @param int $code
     *
     * @return Error
     */
    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return (string)$this->message;
    }

    /**
     * @param string $message
     *
     * @return Error
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            'Error (%d): %s',
            $this->getCode(),
            $this->getMessage()
        );
    }
}
