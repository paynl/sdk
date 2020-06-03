<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Product
 *
 * @package PayNL\Sdk\Model
 */
class Product implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Amount
     */
    protected $price;

    /**
     * @var float
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $vatCode;

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
     * @return Product
     */
    public function setId(string $id): self
    {
        $this->id = $id;
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
     * @return Product
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getPrice(): Amount
    {
        if (null === $this->price) {
            $this->setPrice(new Amount());
        }
        return $this->price;
    }

    /**
     * @param Amount $price
     *
     * @return Product
     */
    public function setPrice(Amount $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return (float)$this->quantity;
    }

    /**
     * @param float $quantity
     *
     * @return Product
     */
    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getVatCode(): string
    {
        return (string)$this->vatCode;
    }

    /**
     * @param string $vatCode
     *
     * @return Product
     */
    public function setVatCode(string $vatCode): self
    {
        $this->vatCode = $vatCode;
        return $this;
    }
}
