<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\PaymentMethod;

/**
 * Interface PaymentMethodAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface PaymentMethodAwareInterface
{
    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod(): PaymentMethod;

    /**
     * @param PaymentMethod $paymentMethod
     *
     * @return static
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod);
}
