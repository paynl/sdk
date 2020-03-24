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
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

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
