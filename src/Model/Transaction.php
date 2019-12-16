<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use DateTime as stdDateTime, JsonSerializable, BadMethodCallException;
use Zend\Filter\Word\CamelCaseToUnderscore;
use PayNL\Sdk\DateTime;

/**
 * Class Transaction
 *
 * @package PayNL\Sdk\Model
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 *
 * @method bool isCancelled()
 * @method bool isPartiallyRefunded()
 * @method bool isRefundedCustomer()
 * @method bool isExpired()
 * @method bool isRefunding()
 * @method bool isChargeback()
 * @method bool isDenied()
 * @method bool isFailure()
 * @method bool isInvalidAmount()
 * @method bool isInitialized()
 * @method bool isProcessing()
 * @method bool isPending()
 * @method bool isSubscriptionOpen()
 * @method bool isProcessed()
 * @method bool isConfirmed()
 * @method bool isPartiallyPaid()
 * @method bool isVerify()
 * @method bool isAuthorized()
 * @method bool isPartiallyAccepted()
 * @method bool isPaid()
 */
class Transaction implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait, LinksTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @required
     *
     * @var string
     */
    protected $serviceId;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $merchantReference;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var DateTime
     */
    protected $expiresAt;

    /**
     * @required
     *
     * @var Amount
     */
    protected $amount;

    /**
     * @var Amount
     */
    protected $amountConverted;

    /**
     * @var Amount
     */
    protected $amountPaid;

    /**
     * @var Amount
     */
    protected $amountRefunded;

    /**
     * @var PaymentMethod
     */
    protected $paymentMethod;

    /**
     * @required
     *
     * @var string
     */
    protected $returnUrl;

    /**
     * @var string
     */
    protected $exchangeUrl;

    /**
     * @var string
     */
    protected $issuerUrl;

    /**
     * @var Transfer
     */
    protected $transfer;

    /**
     * @var string
     */
    protected $domainId;

    /**
     * @var Integration
     */
    protected $integration;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var TransactionStatus
     */
    protected $status;

    /**
     * @var Statistics
     */
    protected $statistics;

    /**
     * @var DateTime
     */
    protected $createdAt;

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
     * @return Transaction
     */
    public function setId(string $id): self
    {
        $this->id = $id;
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
     * @return Transaction
     */
    public function setServiceId(string $serviceId): self
    {
        $this->serviceId = $serviceId;
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
     * @return Transaction
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantReference(): string
    {
        return (string)$this->merchantReference;
    }

    /**
     * @param string $merchantReference
     *
     * @return Transaction
     */
    public function setMerchantReference(string $merchantReference): self
    {
        $this->merchantReference = $merchantReference;
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
     * @return Transaction
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getExpiresAt(): ?DateTime
    {
        return $this->expiresAt;
    }

    /**
     * @param DateTime $expiresAt
     *
     * @return Transaction
     */
    public function setExpiresAt(DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;
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
     * @return Transaction
     */
    public function setAmount(Amount $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getAmountConverted(): ?Amount
    {
        return $this->amountConverted;
    }

    /**
     * @param Amount $amountConverted
     *
     * @return Transaction
     */
    public function setAmountConverted(Amount $amountConverted): self
    {
        $this->amountConverted = $amountConverted;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getAmountPaid(): ?Amount
    {
        return $this->amountPaid;
    }

    /**
     * @param Amount $amountPaid
     *
     * @return Transaction
     */
    public function setAmountPaid(Amount $amountPaid): self
    {
        $this->amountPaid = $amountPaid;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getAmountRefunded(): ?Amount
    {
        return $this->amountRefunded;
    }

    /**
     * @param Amount $amountRefunded
     *
     * @return Transaction
     */
    public function setAmountRefunded(Amount $amountRefunded): self
    {
        $this->amountRefunded = $amountRefunded;
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
     * @return Transaction
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return (string)$this->returnUrl;
    }

    /**
     * @param string $returnUrl
     *
     * @return Transaction
     */
    public function setReturnUrl(string $returnUrl): self
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getExchangeUrl(): ?string
    {
        return (string)$this->exchangeUrl;
    }

    /**
     * @param string $exchangeUrl
     *
     * @return Transaction
     */
    public function setExchangeUrl(string $exchangeUrl): self
    {
        $this->exchangeUrl = $exchangeUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssuerUrl(): string
    {
        return (string)$this->issuerUrl;
    }

    /**
     * @param string $issuerUrl
     *
     * @return Transaction
     */
    public function setIssuerUrl(string $issuerUrl): self
    {
        $this->issuerUrl = $issuerUrl;
        return $this;
    }

    /**
     * @return Transfer|null
     */
    public function getTransfer(): ?Transfer
    {
        return $this->transfer;
    }

    /**
     * @param Transfer $transfer
     *
     * @return Transaction
     */
    public function setTransfer(Transfer $transfer): self
    {
        $this->transfer = $transfer;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomainId(): string
    {
        return (string)$this->domainId;
    }

    /**
     * @param string $domainId
     *
     * @return Transaction
     */
    public function setDomainId(string $domainId): self
    {
        $this->domainId = $domainId;
        return $this;
    }

    /**
     * @return Integration|null
     */
    public function getIntegration(): ?Integration
    {
        return $this->integration;
    }

    /**
     * @param Integration $integration
     *
     * @return Transaction
     */
    public function setIntegration(Integration $integration): self
    {
        $this->integration = $integration;
        return $this;
    }

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     *
     * @return Transaction
     */
    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return TransactionStatus|null
     */
    public function getStatus(): ?TransactionStatus
    {
        return $this->status;
    }

    /**
     * @param TransactionStatus $status
     *
     * @return Transaction
     */
    public function setStatus(TransactionStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Statistics|null
     */
    public function getStatistics(): ?Statistics
    {
        return $this->statistics;
    }

    /**
     * @param Statistics $statistics
     *
     * @return Transaction
     */
    public function setStatistics(Statistics $statistics): self
    {
        $this->statistics = $statistics;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        if (null === $this->createdAt) {
            $this->createdAt = DateTime::now();
        }

        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Transaction
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Magic method to catch all undefined methods.
     *
     * Used to check if the transaction status is equal to a given status
     *
     * @param string $name
     * @param array $arguments
     *
     * @return bool
     */
    public function __call(string $name, array $arguments = [])
    {
        if ('isPending' === $name) {
            return in_array($this->getStatus()->getCode(), [
                TransactionStatus::STATUS_PENDING1,
                TransactionStatus::STATUS_PENDING2,
                TransactionStatus::STATUS_PENDING3,
            ], true);
        }

        if (1 === preg_match('/^is(?P<status>[A-z]+)/', $name, $match)) {
            $statusConstantName = 'STATUS_' . strtoupper((new CamelCaseToUnderscore())->filter($match['status']));
            return $this->getStatus()->is($statusConstantName);
        }

        throw new BadMethodCallException(
            sprintf(
                'Call to undefined method %s::%s',
                self::class,
                $name
            )
        );
    }
}
