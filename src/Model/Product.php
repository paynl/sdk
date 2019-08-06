<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Product
 *
 * @package PayNL\Sdk\Model
 */
class Product implements ModelInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Amount
     */
    protected $price;

    /**
     * @var string
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $vat;

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
     * @return Product
     */
    public function setId(string $id): Product
    {
        $this->id = $id;
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
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getPrice(): Amount
    {
        return $this->price;
    }

    /**
     * @param Amount $price
     *
     * @return Product
     */
    public function setPrice(Amount $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     *
     * @return Product
     */
    public function setQuantity(string $quantity): Product
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getVat(): string
    {
        return $this->vat;
    }

    /**
     * @param string $vat
     *
     * @return Product
     */
    public function setVat(string $vat): Product
    {
        $this->vat = $vat;
        return $this;
    }
}
