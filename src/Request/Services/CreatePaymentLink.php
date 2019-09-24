<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

use PayNL\Sdk\Model\ServicePaymentLink;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\ServiceIdTrait;

/**
 * Class CreatePaymentLink
 *
 * @package PayNL\Sdk\Request\Services
 */
class CreatePaymentLink extends AbstractRequest
{
    use ServiceIdTrait;

    /**
     * CreatePaymentLink constructor.
     *
     * @param string $serviceId
     * @param ServicePaymentLink $servicePaymentLink
     */
    public function __construct(string $serviceId, ServicePaymentLink $servicePaymentLink)
    {
        $this->setServiceId($serviceId);
        $this->setBody($servicePaymentLink);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "services/{$this->getServiceId()}/paymentlink";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }
}
