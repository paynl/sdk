<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class ServiceId
 *
 * @package PayNL\Sdk\Filter
 */
class ServiceId extends AbstractScalarFilter
{
    public function getName(): string
    {
        return 'serviceId';
    }
}
