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
                    'class_method'  => 'getMapperConfig',
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

    public function getMapperConfig(): array
    {
        return [
            'aliases' => [
                'RequestModelMapper' => RequestModelMapper::class,
            ],
            'factories' => [
                RequestModelMapper::class => Factory::class,
            ],
            'mapping' => $this->getMap(),
        ];
    }

    public function getMap(): array
    {
        return [
            'RequestModelMapper' => [
                'GetAllCurrencies'              => 'Currencies',
                'GetCurrency'                   => 'Currency',
                'CreateDirectdebit'             => 'Directdebit',
                'CreateRecurringDirectdebit'    => 'Directdebit',
                'DeleteDirectdebit'             => 'Directdebit',
                'GetDirectdebit'                => 'Directdebit',
                'UpdateDirectdebit'             => 'Directdebit',
                'AddTrademark'                  => 'Merchant',
                'DeleteTrademark'               => 'Merchant',
                'GetMerchant'                   => 'Merchant',
//                'ConfirmTerminalTransaction'    => '',
                'GetReceipt'                    => 'Receipt',
                'GetTerminals'                  => 'Terminals',
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
//            'ModelHydratorMapper' => [
//                'Address'               => 'Entity',
//                'Amount'                => 'Entity',
//                'BankAccount'           => 'Entity',
//                'Card'                  => 'Entity',
//                'Company'               => 'Entity',
//                'ContactMethod'         => 'Entity',
//                'ContactMethods'        => 'Entity',
////                'Currencies'            => 'Currencies',
//                'Currencies'            => 'Entity',
////                'Currency'              => 'Simple',
//                'Currency'              => 'Entity',
//                'Customer'              => 'Entity',
//                'Directdebit'           => 'Entity',
//                'Error'                 => 'Entity',
////                'Errors'                => 'Errors',
//                'Errors'                => 'Entity',
//                'Integration'           => 'Entity',
//                'Interval'              => 'Entity',
//                'Link'                  => 'Entity',
//                'Links'                 => 'Entity',
//                'Mandate'               => 'Entity',
//                'Merchant'              => 'Entity',
//                'Order'                 => 'Entity',
//                'PaymentMethod'         => 'Entity',
//                'PaymentMethods'        => 'Entity',
//                'Product'               => 'Entity',
//                'Products'              => 'Entity',
//                'Progress'              => 'Entity',
//                'Qr'                    => 'Entity',
//                'Receipt'               => 'Entity',
//                'RecurringTransaction'  => 'Entity',
//                'Refund'                => 'Entity',
//                'Service'               => 'Entity',
//                'ServicePaymentLink'    => 'Entity',
//                'Services'              => 'Entity',
//                'Statistics'            => 'Entity',
//                'Status'                => 'Entity',
//                'Terminal'              => 'Entity',
//                'Terminals'             => 'Entity',
//                'TerminalTransaction'   => 'Entity',
//                'Trademark'             => 'Entity',
//                'Trademarks'            => 'Entity',
//                'Transaction'           => 'Entity',
//                'TransactionStatus'     => 'Entity',
//                'Transfer'              => 'Entity',
//                'Voucher'               => 'Entity',
//            ],
        ];
    }
}
