<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class ServicePaymentLink
 *
 * @package PayNL\Sdk\Model
 */
class ServicePaymentLink implements
    ModelInterface,
    Member\AmountAwareInterface,
    Member\StatisticsAwareInterface,
    JsonSerializable
{
    use JsonSerializeTrait;

    /*
     * Security mode constant definitions
     */
    public const SECURITY_MODE_0 = 0;
    public const SECURITY_MODE_1 = 1;
    public const SECURITY_MODE_2 = 2;
    public const SECURITY_MODE_3 = 3;

    use Member\AmountAwareTrait;
    use Member\StatisticsAwareTrait;

    /**
     * @required
     *
     * @var integer
     */
    protected $securityMode = 0;

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
     * @var string
     */
    protected $url;

    /**
     * @return array
     */
    protected function getSecurityModes(): array
    {
        return [
            self::SECURITY_MODE_0,
            self::SECURITY_MODE_1,
            self::SECURITY_MODE_2,
            self::SECURITY_MODE_3,
        ];
    }

    /**
     * @return int
     */
    public function getSecurityMode(): int
    {
        return (int)$this->securityMode;
    }

    /**
     * @param int $securityMode
     *
     * @throws InvalidArgumentException when given security mode is not supported
     *
     * @return ServicePaymentLink
     */
    public function setSecurityMode(int $securityMode): self
    {
        if (false === in_array($securityMode, $this->getSecurityModes(), true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Security mode "%s" is not supported, choose one of the following: %s',
                    $securityMode,
                    implode(', ', $this->getSecurityModes())
                )
            );
        }
        $this->securityMode = $securityMode;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getAmountMin(): ?Amount
    {
        if (null === $this->amountMin) {
            $this->setAmountMin(new Amount());
        }
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
     * @return string
     */
    public function getUrl(): string
    {
        return (string)$this->url;
    }

    /**
     * @param string $url
     *
     * @return ServicePaymentLink
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }
}
