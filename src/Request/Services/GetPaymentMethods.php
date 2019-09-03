<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

/**
 * Class GetPaymentMethods
 *
 * @package PayNL\Sdk\Request\Services
 */
class GetPaymentMethods extends Get
{
    public function getUri(): string
    {
        return "services/{$this->getServiceId()}/paymentmethods";
    }
}
