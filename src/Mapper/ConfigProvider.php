<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;


use PayNL\Sdk\Common\ManagerFactory;
use PayNL\Sdk\Config\ProviderInterface;

class ConfigProvider implements ProviderInterface
{
    public function __invoke(): array
    {
        return [
            'service_manager' => $this->getDependencyConfig(),
            'service_loader_options' => [
                'mapperManager' => [
                    'service_manager' => 'mapperManager',
                    'config_key'    => 'mappers',
                    'class_method'  => 'getMappers',
                ],
            ],
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'aliases' => [
                'mapperManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    public function getMappers(): array
    {
        return [
            'aliases' => [
                'RequestModelMapper' => RequestModelMapper::class,
                'ModelHydratorMapper' => ModelHydratorMapper::class,
            ],
            'factories' => [
                RequestModelMapper::class => Factory::class,
                ModelHydratorMapper::class => Factory::class,
            ],
            'mapping' => $this->getMap(),
        ];
    }

    public function getMap(): array
    {
        return [
            'RequestModelMapper' => [
                'GetAllCurrencies' => 'Currencies',
                'GetCurrency'                 => 'Currency',
                'CreateDirectdebit'             => 'Directdebit',
                'CreateRecurringDirectdebit'    => 'Directdebit',
                'DeleteDirectdebit'             => 'Directdebit',
                'GetDirectdebit'                => 'Directdebit',
                'UpdateDirectdebit'             => 'Directdebit',
//                'IsPay'                         => '',
                'AddTrademark'                  => 'Merchant',
                'DeleteTrademark'               => 'Merchant',
                'GetMerchant'                   => 'Merchant',
//                'ConfirmTerminalTransaction'    => '',
//                'GetReceipt'                    => '',
//                'GetTerminals'                  => '',
//                'GetTerminalTransactionStatus'  => '',
//                'PayTransaction'                => '',
//                'DecodeQr'                      => '',
//                'EncodeQr'                      => '',
//                'ValidateQr'                    => '',
//                'GetRefunds'                    => '',
//                'CreatePaymentLink'             => '',
//                'GetService'                    => '',
//                'GetAllServices'                => '',
//                'GetPaymentMethods'             => '',
//                'ApproveTransaction'            => '',
//                'CancelTransaction'             => '',
//                'CaptureTransaction'            => '',
                'CreateTransaction'             => 'Transaction',
//                'DeclineTransaction'            => '',
//                'GetTransaction'                => '',
//                'CaptureTransactionByQr'        => '',
//                'MakeTransactionRecurring'      => '',
//                'RefundTransaction'             => '',
//                'TokenizeTransaction'           => '',
//                'ActivateVoucher'               => '',
//                'CheckVoucherBalance'           => '',
//                'ChargeVoucher'                 => '',
            ],
            'ModelHydratorMapper' => [
                'Address'               => 'Simple',
                'Amount'                => 'Simple',
                'BankAccount'           => 'Simple',
                'Card'                  => 'Simple',
                'Company'               => 'Simple',
                'ContactMethod'         => 'Simple',
                'ContactMethods'        => 'ContactMethods',
                'Currencies'            => 'Currencies',
                'Currency'              => 'Simple',
                'Customer'              => 'Customer',
                'Directdebit'           => 'Directdebit',
                'Error'                 => 'Simple',
                'Errors'                => 'Errors',
                'Integration'           => 'Simple',
                'Interval'              => 'Simple',
                'Link'                  => 'Link',
                'Links'                 => 'Links',
                'Mandate'               => 'Mandate',
                'Merchant'              => 'Merchant',
                'Order'                 => 'Order',
                'PaymentMethod'         => 'PaymentMethod',
                'PaymentMethods'        => 'PaymentMethods',
                'Product'               => 'Product',
                'Products'              => 'Products',
                'Progress'              => 'Simple',
                'Qr'                    => 'Qr',
                'Receipt'               => 'Receipt',
                'RecurringTransaction'  => 'RecurringTransaction',
                'Refund'                => 'Refund',
                'Service'               => 'Service',
                'ServicePaymentLink'    => 'ServicePaymentLink',
                'Services'              => 'Services',
                'Statistics'            => 'Simple',
                'Status'                => 'Status',
                'Terminal'              => 'Simple',
                'Terminals'             => 'Terminals',
                'TerminalTransaction'   => 'TerminalTransaction',
                'Trademark'             => 'Simple',
                'Trademarks'            => 'Trademarks',
                'Transaction'           => 'Transaction',
                'TransactionStatus'     => 'Status',
                'Transfer'              => 'Simple',
                'Voucher'               => 'Voucher',
            ],
        ];
    }
}
