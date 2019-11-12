<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\PaymentMethod as PaymentMethodTransformer
};
use PayNL\Sdk\Request\Parameter\ServiceIdTrait;

/**
 * Class GetPaymentMethods
 *
 * @package PayNL\Sdk\Request\Services
 */
class GetPaymentMethods extends AbstractRequest
{
    use ServiceIdTrait;

    /**
     * GetPaymentMethods constructor.
     *
     * @param string $serviceId
     */
    public function __construct(string $serviceId)
    {
        $this->setServiceId($serviceId);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "services/{$this->getServiceId()}/paymentmethods";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @return PaymentMethodTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new PaymentMethodTransformer();
    }
}
