<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;

/**
 * Class ServicePaymentLink
 *
 * @package PayNL\Sdk\Model
 */
class ServicePaymentLink implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @required
     *
     * @var integer
     */
    protected $securityMode = 0;

    /**
     * @var Amount
     */
    protected $amount;

    /**
     * @var Amount
     */
    protected $amountMin;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var Statistics
     */
    protected $statistics;

    /**
     * @return int
     */
    public function getSecurityMode(): int
    {
        return $this->securityMode;
    }

    /**
     * @param int $securityMode
     *
     * @return ServicePaymentLink
     */
    public function setSecurityMode(int $securityMode): self
    {
        $this->securityMode = $securityMode;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     *
     * @return ServicePaymentLink
     */
    public function setAmount(Amount $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmountMin(): Amount
    {
        return $this->amountMin;
    }

    /**
     * @param Amount $amountMin
     *
     * @return ServicePaymentLink
     */
    public function setAmountMin(Amount $amountMin): self
    {
        $this->amountMin = $amountMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return (string)$this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return ServicePaymentLink
     */
    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return (string)$this->language;
    }

    /**
     * @param string $language
     *
     * @return ServicePaymentLink
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return Statistics
     */
    public function getStatistics(): Statistics
    {
        return $this->statistics;
    }

    /**
     * @param Statistics $statistics
     *
     * @return ServicePaymentLink
     */
    public function setStatistics(Statistics $statistics): self
    {
        $this->statistics = $statistics;
        return $this;
    }
}
