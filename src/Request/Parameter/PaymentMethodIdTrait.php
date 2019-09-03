<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Parameter;

/**
 * Trait PaymentMethodIdTrait
 *
 * @package PayNL\Sdk\Request\Parameter
 */
trait PaymentMethodIdTrait
{
    /**
     * @var int
     */
    protected $paymentMethodId;

    /**
     * @return int
     */
    public function getPaymentMethodId(): int
    {
        return $this->paymentMethodId;
    }

    /**
     * @param int $paymentMethodId
     *
     * @return PaymentMethodIdTrait
     */
    public function setPaymentMethodId(int $paymentMethodId): self
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }
}
