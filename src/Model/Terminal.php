<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Terminal
 *
 * @package PayNL\Sdk\Model
 */
class Terminal implements ModelInterface
{
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
        return $this->id;
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
        return $this->name;
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
        return $this->ecrProtocol;
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
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Terminal
     */
    public function setState(string $state): self
    {
        $this->state = $state;
        return $this;
    }
}
