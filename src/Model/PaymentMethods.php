<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\{JsonSerializeTrait, TotalCollection};

/**
 * Class PaymentMethods
 *
 * @package PayNL\Sdk\Model
 */
class PaymentMethods extends TotalCollection implements ModelInterface, JsonSerializable
{
    use LinksTrait, JsonSerializeTrait;

    /**
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $paymentMethods
     *
     * @return PaymentMethods
     */
    public function setPaymentMethods(array $paymentMethods): self
    {
        // reset the total
        $this->clear();

        if (0 === count($paymentMethods)) {
            return $this;
        }

        foreach ($paymentMethods as $paymentMethod) {
            $this->addPaymentMethod($paymentMethod);
        }
        return $this;
    }

    /**
     * @param PaymentMethod $paymentMethod
     *
     * @return PaymentMethods
     */
    public function addPaymentMethod(PaymentMethod $paymentMethod): self
    {
        $this->set($paymentMethod->getId(), $paymentMethod);
        return $this;
    }

    public function getCollectionName(): string
    {
        return 'paymentMethods';
    }
}
