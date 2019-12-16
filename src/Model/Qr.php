<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class Qr
 *
 * @package PayNL\Sdk\Model
 */
class Qr implements ModelInterface, JsonSerializable
{
    /*
     * Reference type constant definitions
     */
    public const REFERENCE_TYPE_STRING = 'string';
    public const REFERENCE_TYPE_HEX    = 'hex';

    use JsonSerializeTrait;

    /**
     * @required
     *
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $serviceId;

    /**
     * @required
     *
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
        return (string)$this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return Qr
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return (string)$this->serviceId;
    }

    /**
     * @param string $serviceId
     *
     * @return Qr
     */
    public function setServiceId(string $serviceId): self
    {
        $this->serviceId = $serviceId;
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
     * @return Qr
     */
    public function setSecret(string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return (string)$this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Qr
     */
    public function setReference(string $reference): self
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
    public function setPadChar(string $padChar): self
    {
        $this->padChar = $padChar;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceType(): string
    {
        return (string)$this->referenceType;
    }

    /**
     * @param string $referenceType
     *
     * @throws InvalidArgumentException when the reference type given is not supported
     *
     * @return Qr
     */
    public function setReferenceType(string $referenceType): self
    {
        if (false === in_array($referenceType, [ self::REFERENCE_TYPE_STRING, self::REFERENCE_TYPE_HEX ], true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Value "%s" is not supported as reference type',
                    $referenceType
                )
            );
        }

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
    public function setPaymentMethod(PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
}
