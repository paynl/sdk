<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\{
    JsonSerializeTrait,
    AbstractTotalCollection
};

/**
 * Class PaymentMethods
 *
 * @package PayNL\Sdk\Model
 */
class PaymentMethods extends AbstractTotalCollection implements ModelInterface, JsonSerializable, Member\LinksAwareInterface
{
    use Member\LinksAwareTrait;
    use JsonSerializeTrait;

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

    /**
     * @inheritDoc
     */
    public function getCollectionName(): string
    {
        return 'paymentMethods';
    }
}
