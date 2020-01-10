<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Config\ProviderInterface as ConfigProviderInterface,
    Common\ManagerFactory
};

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
            'factories' => [
                Currencies::class           => Factory::class,
                Simple::class               => Factory::class,
                Links:: class               => Factory::class,
                Link::class                 => Factory::class,
                ContactMethods::class       => Factory::class,
                Customer::class             => Factory::class,
                Directdebit::class          => Factory::class,
                Errors::class               => Factory::class,
                Mandate::class              => Factory::class,
                Merchant::class             => Factory::class,
                Order::class                => Factory::class,
                PaymentMethod::class        => Factory::class,
                PaymentMethods::class       => Factory::class,
                Product::class              => Factory::class,
                Products::class             => Factory::class,
                Qr::class                   => Factory::class,
                Receipt::class              => Factory::class,
                RecurringTransaction::class => Factory::class,
                Refund::class               => Factory::class,
                Service::class              => Factory::class,
                ServicePaymentLink::class   => Factory::class,
                Services::class             => Factory::class,
                Status::class               => Factory::class,
                Terminals::class            => Factory::class,
                TerminalTransaction::class  => Factory::class,
                Trademarks::class           => Factory::class,
                Transaction::class          => Factory::class,
                Voucher::class              => Factory::class,


            ],
            'aliases' => [
                'currencies'            => Currencies::class,
                'Currencies'            => Currencies::class,
                'contactMethods'        => ContactMethods::class,
                'ContactMethods'        => ContactMethods::class,
                'customer'              => Customer::class,
                'Customer'              => Customer::class,
                'directdebit'           => Directdebit::class,
                'Directdebit'           => Directdebit::class,
                'errors'                => Errors::class,
                'Errors'                => Errors::class,
                'link'                  => Link::class,
                'Link'                  => Link::class,
                'links'                 => Links::class,
                'Links'                 => Links::class,
                'mandate'               => Mandate::class,
                'Mandate'               => Mandate::class,
                'merchant'              => Merchant::class,
                'Merchant'              => Merchant::class,
                'order'                 => Order::class,
                'Order'                 => Order::class,
                'paymentMethod'         => PaymentMethod::class,
                'PaymentMethod'         => PaymentMethod::class,
                'paymentMethods'        => PaymentMethods::class,
                'PaymentMethods'        => PaymentMethods::class,
                'product'               => Product::class,
                'Product'               => Product::class,
                'products'              => Products::class,
                'Products'              => Products::class,
                'qr'                    => Qr::class,
                'Qr'                    => Qr::class,
                'receipt'               => Receipt::class,
                'Receipt'               => Receipt::class,
                'recurringTransaction'  => RecurringTransaction::class,
                'RecurringTransaction'  => RecurringTransaction::class,
                'refund'                => Refund::class,
                'Refund'                => Refund::class,
                'service'               => Service::class,
                'Service'               => Service::class,
                'servicePaymentLink'    => ServicePaymentLink::class,
                'ServicePaymentLink'    => ServicePaymentLink::class,
                'services'              => Services::class,
                'Services'              => Services::class,
                'Simple'                => Simple::class,
                'simple'                => Simple::class,
                'status'                => Status::class,
                'Status'                => Status::class,
                'terminals'             => Terminals::class,
                'Terminals'             => Terminals::class,
                'terminalTransaction'   => TerminalTransaction::class,
                'TerminalTransaction'   => TerminalTransaction::class,
                'trademarks'            => Trademarks::class,
                'Trademarks'            => Trademarks::class,
                'transaction'           => Transaction::class,
                'Transaction'           => Transaction::class,
                'voucher'               => Voucher::class,
                'Voucher'               => Voucher::class,
            ],
        ];
    }
}
