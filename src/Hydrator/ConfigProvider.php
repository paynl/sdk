<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;
use PayNL\Sdk\Common\ManagerFactory;
use PayNL\Sdk\Common\InvokableFactory;
use PayNL\Sdk\Model;

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Hydrator
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [
            'service_manager' => $this->getDependencyConfig(),
            'service_loader_options' => [
                'hydratorManager' => [
                    'service_manager' => 'hydratorManager',
                    'config_key'      => 'hydrators',
                    'class_method'    => 'getHydratorConfig'
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
                'hydratorManager' => Manager::class,
            ],
            'factories' => [
                Manager::class =>  ManagerFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getHydratorConfig(): array
    {
        return [
            'invokables' => [
                'ContactMethods'        => ContactMethods::class,
                'Customer'              => Customer::class,
                'Directdebit'           => Directdebit::class,
                'Errors'                => Errors::class,
//                'Link'                  => Link::class,
//                'Links'                 => Links::class,
                'Mandate'               => Mandate::class,
                'Merchant'              => Merchant::class,
                'Order'                 => Order::class,
                'PaymentMethod'         => PaymentMethod::class,
                'PaymentMethods'        => PaymentMethods::class,
                'Product'               => Product::class,
                'Products'              => Products::class,
                'Qr'                    => Qr::class,
                'Receipt'               => Receipt::class,
                'RecurringTransaction'  => RecurringTransaction::class,
                'Refund'                => Refund::class,
                'Service'               => Service::class,
                'ServicePaymentLink'    => ServicePaymentLink::class,
                'Services'              => Services::class,
//                'Simple'                => Simple::class,
                'Status'                => Status::class,
                'Terminals'             => Terminals::class,
                'TerminalTransaction'   => TerminalTransaction::class,
                'Trademarks'            => Trademarks::class,
                'Transaction'           => Transaction::class,
                'Voucher'               => Voucher::class,
            ],
            'factories' => [
                Currencies::class => Factory::class,
                Simple::class => Factory::class,
                Links:: class => Factory::class,
                Link::class => Factory::class,
            ],
            'aliases' => [
                'Currencies' => Currencies::class,
                'currencies' => Currencies::class,
                'contactMethods'        => 'ContactMethods',
                'customer'              => 'Customer',
                'directdebit'           => 'Directdebit',
                'errors'                => 'Errors',
                'link'                  => Link::class,
                'Link'                  => Link::class,
                'links'                 => Links::class,
                'Links'                 => Links::class,
                'mandate'               => 'Mandate',
                'merchant'              => 'Merchant',
                'order'                 => 'Order',
                'paymentMethod'         => 'PaymentMethod',
                'paymentMethods'        => 'PaymentMethods',
                'product'               => 'Product',
                'products'              => 'Products',
                'qr'                    => 'Qr',
                'receipt'               => 'Receipt',
                'recurringTransaction'  => 'RecurringTransaction',
                'refund'                => 'Refund',
                'service'               => 'Service',
                'servicePaymentLink'    => 'ServicePaymentLink',
                'services'              => 'Services',
                'Simple'                => Simple::class,
                'simple'                => Simple::class,
                'status'                => 'Status',
                'terminals'             => 'Terminals',
                'terminalTransaction'   => 'TerminalTransaction',
                'trademarks'            => 'Trademarks',
                'transaction'           => 'Transaction',
                'voucher'               => 'Voucher',
            ],
        ];
    }
}
