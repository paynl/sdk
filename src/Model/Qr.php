<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;

/**
 * Class Qr
 *
 * @package PayNL\Sdk\Model
 */
class Qr implements ModelInterface, JsonSerializable
{
    public const REFERENCE_TYPE_STRING = 'string';
    public const REFERENCE_TYPE_HEX    = 'hex';

    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $serviceId;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var string
     */
    protected $padChar = '0';

    /**
     * @var string
     */
    protected $referenceType = self::REFERENCE_TYPE_STRING;

    /**
     * @var PaymentMethod|null
     */
    protected $paymentMethod;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return Qr
     */
    public function setUuid(string $uuid): Qr
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    /**
     * @param string $serviceId
     *
     * @return Qr
     */
    public function setServiceId(string $serviceId): Qr
    {
        $this->serviceId = $serviceId;
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
     * @return Qr
     */
    public function setSecret(string $secret): Qr
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Qr
     */
    public function setReference(string $reference): Qr
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getPadChar(): string
    {
        return $this->padChar;
    }

    /**
     * @param string $padChar
     *
     * @return Qr
     */
    public function setPadChar(string $padChar): Qr
    {
        $this->padChar = $padChar;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceType(): string
    {
        return $this->referenceType;
    }

    /**
     * @param string $referenceType
     *
     * @return Qr
     */
    public function setReferenceType(string $referenceType): Qr
    {
        $this->referenceType = $referenceType;
        return $this;
    }

    /**
     * @return PaymentMethod|null
     */
    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethod $paymentMethod
     *
     * @return Qr
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod): Qr
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
}
