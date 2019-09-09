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
     * @var integer
     */
    protected $paymentMethodId;

    /**
     * @return integer
     */
    public function getPaymentMethodId(): int
    {
        return $this->paymentMethodId;
    }

    /**
     * @param integer $paymentMethodId
     *
     * @return static
     */
    public function setPaymentMethodId(int $paymentMethodId): self
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }
}
