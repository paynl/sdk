<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\PaymentMethod;

/**
 * Trait PaymentMethodAwareTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait PaymentMethodAwareTrait
{
    /**
     * @var PaymentMethod
     */
    protected $paymentMethod;

    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod(): PaymentMethod
    {
        if (null === $this->paymentMethod) {
            $this->setPaymentMethod(new PaymentMethod());
        }
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethod $paymentMethod
     *
     * @return static
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
}
