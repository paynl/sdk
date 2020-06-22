<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Model
 */
class Service implements
    ModelInterface,
    Member\LinksAwareInterface,
    Member\CreatedAtAwareInterface
{
    use Member\LinksAwareTrait;
    use Member\CreatedAtAwareTrait;

    /**
     * @required
     *
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
    protected $description = '';

    /**
     * @var bool
     */
    protected $testMode = Integration::TEST_MODE_OFF;

    /**
     * @var string
     */
    protected $secret = '';

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
     * @return Service
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
     * @return Service
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->description;
    }

    /**
     * @param string $description
     *
     * @return Service
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     *
     * @throws InvalidArgumentException when given test mode is invalid
     *
     * @return Service
     */
    public function setTestMode(bool $testMode): self
    {
        $this->testMode = $testMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return (string)$this->secret;
    }

    /**
     * @param string $secret
     *
     * @return Service
     */
    public function setSecret(string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }
}
