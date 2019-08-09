<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Receipt
 *
 * @package PayNL\Sdk\Model
 */
class Receipt implements ModelInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $approvalId;

    /**
     * @var Card
     */
    protected $card;

    /**
     * @var PaymentMethod
     */
    protected $paymentMethod;

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
     * @return Receipt
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     *
     * @return Receipt
     */
    public function setSignature(string $signature): self
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * @return string
     */
    public function getApprovalId(): string
    {
        return $this->approvalId;
    }

    /**
     * @param string $approvalId
     *
     * @return Receipt
     */
    public function setApprovalId(string $approvalId): self
    {
        $this->approvalId = $approvalId;
        return $this;
    }

    /**
     * @return Card
     */
    public function getCard(): Card
    {
        return $this->card;
    }

    /**
     * @param Card $card
     *
     * @return Receipt
     */
    public function setCard(Card $card): self
    {
        $this->card = $card;
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
     * @return Receipt
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
}
