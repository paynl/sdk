<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Exception\InvalidServiceException;

/**
 * Class Terminal
 *
 * @package PayNL\Sdk\Model
 */
class Terminal implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    public const STATE_ALL      = 'all';
    public const STATE_NEW      = 'new';
    public const STATE_ORDERED  = 'ordered';
    public const STATE_STOCKED  = 'stocked';
    public const STATE_ACTIVE   = 'active';
    public const STATE_INACTIVE = 'inactive';
    public const STATE_RMA      = 'rma';
    public const STATE_FINAL    = 'final';

    public const STATES = [
        self::STATE_ALL,
        self::STATE_NEW,
        self::STATE_ORDERED,
        self::STATE_STOCKED,
        self::STATE_ACTIVE,
        self::STATE_INACTIVE,
        self::STATE_RMA,
        self::STATE_FINAL,
    ];

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $ecrProtocol;

    /**
     * @var string
     */
    protected $state;

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
    }

    /**
     * @param string $id
     *
     * @return Terminal
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     *
     * @return Terminal
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEcrProtocol(): string
    {
        return (string)$this->ecrProtocol;
    }

    /**
     * @param string $ecrProtocol
     *
     * @return Terminal
     */
    public function setEcrProtocol(string $ecrProtocol): self
    {
        $this->ecrProtocol = $ecrProtocol;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return (string)$this->state;
    }

    /**
     * @param string $state
     *
     * @throws InvalidServiceException
     *
     * @return Terminal
     */
    public function setState(string $state): self
    {
        if (false === in_array($state, self::STATES, true)) {
            throw new InvalidServiceException(
                sprintf(
                    'State "%s" is not allowed, choose one of "%s"',
                    $state,
                    implode('", "', self::STATES)
                )
            );
        }
        $this->state = $state;
        return $this;
    }
}
