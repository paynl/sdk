<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use DateTime, JsonSerializable, BadMethodCallException;
use Zend\Filter\Word\CamelCaseToUnderscore;

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
     * @var string
     */
    protected $serviceId;

    /**
     * @var TransactionStatus
     */
    protected $status;

    /**
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
    protected $reference;

    /**
     * @var PaymentMethod
     */
    protected $paymentMethod;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $issuerUrl;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var string
     */
    protected $orderNumber;

    /**
     * @var DateTime
     */
    protected $invoiceDate;

    /**
     * @var DateTime
     */
    protected $deliveryDate;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var Address
     */
    protected $billingAddress;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var array
     *
     * Collections of Products
     * @see Product
     */
    protected $products = [];

    /**
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
     * @var Statistics
     */
    protected $statistics;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $expiresAt;

    /**
     * @var integer
     */
    protected $testMode = 0;

    /**
     * @var string
     */
    protected $transferType;

    /**
     * @var string
     */
    protected $transferValue;

    /**
     * @var string
     */
    protected $endUserId;

    /**
     * @var Company
     */
    protected $company;

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
        return $this->serviceId;
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
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
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
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->returnUrl;
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
        return $this->exchangeUrl;
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
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Transaction
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod(): PaymentMethod
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
    public function getDescription(): string
    {
        return $this->description;
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
    public function getIssuerUrl(): string
    {
        return $this->issuerUrl;
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
     * @return string
     */
    public function getOrderId(): string
    {
        return (string)$this->orderId;
    }

    /**
     * @param string $orderId
     *
     * @return Transaction
     */
    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     *
     * @return Transaction
     */
    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getInvoiceDate(): DateTime
    {
        return $this->invoiceDate;
    }

    /**
     * @param DateTime $invoiceDate
     *
     * @return Transaction
     */
    public function setInvoiceDate(DateTime $invoiceDate): self
    {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDeliveryDate(): DateTime
    {
        return $this->deliveryDate;
    }

    /**
     * @param DateTime $deliveryDate
     *
     * @return Transaction
     */
    public function setDeliveryDate(DateTime $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     *
     * @return Transaction
     */
    public function setAddress(Address $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return Address
     */
    public function getBillingAddress(): Address
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     *
     * @return Transaction
     */
    public function setBillingAddress(Address $billingAddress): self
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     *
     * @return Transaction
     */
    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $products
     *
     * @return Transaction
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;
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
     * @return Amount
     */
    public function getAmountConverted(): Amount
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
     * @return Amount
     */
    public function getAmountPaid(): Amount
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
     * @return Amount
     */
    public function getAmountRefunded(): Amount
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
     * @return Statistics
     */
    public function getStatistics(): Statistics
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
     * @return DateTime
     */
    public function getExpiresAt(): DateTime
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
     * @return integer
     */
    public function getTestMode(): int
    {
        return $this->testMode;
    }

    /**
     * @param integer $testMode
     *
     * @return Transaction
     */
    public function setTestMode(int $testMode): self
    {
        $this->testMode = $testMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransferType(): string
    {
        return $this->transferType;
    }

    /**
     * @param string $transferType
     *
     * @return Transaction
     */
    public function setTransferType(string $transferType): self
    {
        $this->transferType = $transferType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransferValue(): string
    {
        return $this->transferValue;
    }

    /**
     * @param string $transferValue
     *
     * @return Transaction
     */
    public function setTransferValue(string $transferValue): self
    {
        $this->transferValue = $transferValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndUserId(): string
    {
        return $this->endUserId;
    }

    /**
     * @param string $endUserId
     *
     * @return Transaction
     */
    public function setEndUserId(string $endUserId): self
    {
        $this->endUserId = $endUserId;
        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     *
     * @return Transaction
     */
    public function setCompany(Company $company): self
    {
        $this->company = $company;
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
