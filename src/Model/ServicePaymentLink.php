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
     * @var integer
     */
    protected $securityMode;

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
    public function setSecurityMode(int $securityMode): ServicePaymentLink
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
    public function setAmount(Amount $amount): ServicePaymentLink
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
    public function setAmountMin(Amount $amountMin): ServicePaymentLink
    {
        $this->amountMin = $amountMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return ServicePaymentLink
     */
    public function setCountryCode(string $countryCode): ServicePaymentLink
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return ServicePaymentLink
     */
    public function setLanguage(string $language): ServicePaymentLink
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
    public function setStatistics(Statistics $statistics): ServicePaymentLink
    {
        $this->statistics = $statistics;
        return $this;
    }
}
