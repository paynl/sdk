<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;

/**
 * Class PaymentMethod
 *
 * @package PayNL\Sdk\Model
 */
class PaymentMethod implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer|null
     */
    protected $subId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $image;

    /**
     * @var array
     */
    protected $countryCodes = [];

    /**
     * @var PaymentMethods
     */
    protected $subMethods;

    public function __construct()
    {
        $this->subMethods = new PaymentMethods();
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return PaymentMethod
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getSubId(): ?int
    {
        return $this->subId;
    }

    /**
     * @param int $subId
     *
     * @return PaymentMethod
     */
    public function setSubId(int $subId): self
    {
        $this->subId = $subId;
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
     * @return PaymentMethod
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return (string)$this->image;
    }

    /**
     * @param string $image
     *
     * @return PaymentMethod
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return array
     */
    public function getCountryCodes(): array
    {
        return $this->countryCodes;
    }

    /**
     * @param array $countryCodes
     *
     * @return PaymentMethod
     */
    public function setCountryCodes(array $countryCodes): self
    {
        $this->countryCodes = $countryCodes;
        return $this;
    }

    /**
     * @param string $countryCode
     *
     * @return $this
     */
    public function addCountryCode(string $countryCode): self
    {
        $this->countryCodes[] = $countryCode;
        return $this;
    }

    /**
     * @return PaymentMethods
     */
    public function getSubMethods(): PaymentMethods
    {
        return $this->subMethods;
    }

    /**
     * @param PaymentMethods $subMethods
     *
     * @return PaymentMethod
     */
    public function setSubMethods(PaymentMethods $subMethods): self
    {
        $this->subMethods = $subMethods;

        return $this;
    }

    public function addSubMethod(self $paymentMethod): self
    {
        $this->subMethods->addPaymentMethod($paymentMethod);
        return $this;
    }
}
