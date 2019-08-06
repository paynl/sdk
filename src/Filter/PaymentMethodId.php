<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class PaymentMethodId
 *
 * @package PayNL\Sdk\Filter
 */
class PaymentMethodId extends AbstractFilter
{
    public function getName(): string
    {
        return 'paymentMethodId';
    }
}
