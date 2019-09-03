<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class PaymentMethodId
 *
 * @package PayNL\Sdk\Filter
 */
class PaymentMethodId extends AbstractScalarFilter
{
    public function getName(): string
    {
        return 'paymentMethodId';
    }
}
