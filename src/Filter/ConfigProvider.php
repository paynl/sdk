<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use PayNL\Sdk\Common\ManagerFactory;
use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Filter
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [
            'service_manager'        => $this->getDependencyConfig(),
            'service_loader_options' => [
                'filterManager' => [
                    'service_manager' => 'filterManager',
                    'config_key'      => 'filters',
                    'class_method'    => 'getFilterConfig',
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases' => [
                'filterManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    public function getFilterConfig(): array
    {
        return [
            'aliases' => [
                'currency'        => 'Currency',
                'endDate'         => 'EndDate',
                'filters'         => 'Filters',
                'groupBy'         => 'GroupBy',
                'page'            => 'Page',
                'paymentMethodId' => 'PaymentMethodId',
                'serviceId'       => 'ServiceId',
                'staffels'        => 'Staffels',
                'startDate'       => 'StartDate',
                'transactionId'   => 'TransactionId',
            ],
            'invokables' => [
                'Currency'        => Currency::class,
                'EndDate'         => EndDate::class,
                'Filters'         => Filters::class,
                'GroupBy'         => GroupBy::class,
                'Page'            => Page::class,
                'PaymentMethodId' => PaymentMethodId::class,
                'ServiceId'       => ServiceId::class,
                'Staffels'        => Staffels::class,
                'StartDate'       => StartDate::class,
                'TransactionId'   => TransactionId::class,
            ],
        ];
    }
}
