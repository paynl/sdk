<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Statistics
 *
 * @package PayNL\Sdk\Model
 */
class Notification implements
    ModelInterface,
    JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $recipient;

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return (string) $this->type;
    }

    /**
     * @param string $recipient
     * @return $this
     */
    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return (string) $this->recipient;
    }
}
