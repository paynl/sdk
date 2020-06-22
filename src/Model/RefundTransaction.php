<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class RefundTransaction
 *
 * @package PayNL\Sdk\Model
 */
class RefundTransaction implements
    ModelInterface,
    Member\AmountAwareInterface
{
    use Member\AmountAwareTrait;

    /**
     * @var Amount
     */
    protected $amountRefunded;

    /**
     * @var Refund
     */
    protected $refund;

    /**
     * @var Voucher
     */
    protected $voucher;

    /**
     * @return Amount
     */
    public function getAmountRefunded(): Amount
    {
        if (null === $this->amountRefunded) {
            $this->setAmountRefunded(new Amount());
        }
        return $this->amountRefunded;
    }

    /**
     * @param Amount $amountRefunded
     *
     * @return RefundTransaction
     */
    public function setAmountRefunded(Amount $amountRefunded): self
    {
        $this->amountRefunded = $amountRefunded;
        return $this;
    }

    /**
     * @return Refund
     */
    public function getRefund(): Refund
    {
        if (null === $this->refund) {
            $this->setRefund(new Refund());
        }
        return $this->refund;
    }

    /**
     * @param Refund $refund
     *
     * @return RefundTransaction
     */
    public function setRefund(Refund $refund): self
    {
        $this->refund = $refund;
        return $this;
    }

    /**
     * @return Voucher|null
     */
    public function getVoucher(): ?Voucher
    {
        return $this->voucher;
    }

    /**
     * @param Voucher $voucher
     * @return RefundTransaction
     */
    public function setVoucher(Voucher $voucher): RefundTransaction
    {
        $this->voucher = $voucher;
        return $this;
    }
}
