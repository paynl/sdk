<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\DateTime;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Model
 */
class Service implements ModelInterface
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
    protected $description = '';

    /**
     * @var integer
     */
    protected $testMode = 0;

    /**
     * @var string
     */
    protected $secret = '';

    /**
     * @var DateTime|null
     */
    protected $createdAt;

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
     * @return Service
     */
    public function setId(string $id): Service
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
     * @return Service
     */
    public function setName(string $name): Service
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Service
     */
    public function setDescription(string $description): Service
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return integer
     */
    public function getTestMode(): int
    {
        return $this->testMode;
    }

    /**
     * @param integer $testMode
     *
     * @return Service
     */
    public function setTestMode(int $testMode): Service
    {
        $this->testMode = $testMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     *
     * @return Service
     */
    public function setSecret(string $secret): Service
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Service
     */
    public function setCreatedAt(DateTime $createdAt): Service
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
