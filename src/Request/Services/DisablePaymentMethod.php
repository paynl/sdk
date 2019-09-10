<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter;

/**
 * Class DisablePaymentMethod
 *
 * @package PayNL\Sdk\Request\Services
 */
class DisablePaymentMethod extends AbstractRequest
{
    use Parameter\ServiceIdTrait, Parameter\PaymentMethodIdTrait;

    /**
     * DisablePaymentMethod constructor.
     *
     * @param string $serviceId
     * @param int $paymentMethodId
     */
    public function __construct(string $serviceId, int $paymentMethodId)
    {
        $this->setServiceId($serviceId)
            ->setPaymentMethodId($paymentMethodId)
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "services/{$this->getServiceId()}/paymentmethods/{$this->getPaymentMethodId()}/disable";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }
}
