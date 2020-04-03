<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

use PayNL\Sdk\{
    Config\ProviderInterface,
    Common\ManagerFactory
};

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Mapper
 */
class ConfigProvider implements ProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [
            'service_manager' => $this->getDependencyConfig(),
            'service_loader_options' => [
                Manager::class => [
                    'service_manager' => 'mapperManager',
                    'config_key'      => 'mappers',
                    'class_method'    => 'getMapperConfig',
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
                'mapperManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    /**
     * Service manager definition for the models of this component
     *
     * @return array
     */
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

    /**
     * Mapping for setting the correct model for the corresponding request. If a
     * request is not in the list the text for the corresponding status code will
     * be shown.
     *
     * @return array
     */
    public function getMap(): array
    {
        return [
            'RequestModelMapper' => [
                'GetAllCurrencies'              => 'Currencies',
                'GetCurrency'                   => 'Currency',
                'CreateDirectdebit'             => 'DirectdebitOverview',
                'CreateRecurringDirectdebit'    => 'DirectdebitOverview',
                'GetDirectdebit'                => 'DirectdebitOverview',
                'UpdateDirectdebit'             => 'DirectdebitOverview',
                'AddTrademark'                  => 'Merchant',
                'DeleteTrademark'               => 'Merchant',
                'GetMerchant'                   => 'Merchant',
                'ConfirmTerminalTransaction'    => 'TerminalTransaction',
                'GetReceipt'                    => 'Receipt',
                'GetTerminals'                  => 'Terminals',
                'GetTerminalTransactionStatus'  => 'TerminalTransaction',
                'PayTransaction'                => 'TerminalTransaction',
                'DecodeQr'                      => 'Qr',
                'EncodeQr'                      => 'Qr',
                'GetRefund'                     => 'Refund',
                'CreatePaymentLink'             => 'ServicePaymentLink',
                'GetService'                    => 'Service',
                'GetAllServices'                => 'Services',
                'GetPaymentMethods'             => 'PaymentMethods',
                'ApproveTransaction'            => 'Transaction',
                'CancelTransaction'             => 'Transaction',
                'CaptureTransaction'            => 'Transaction',
                'CreateTransaction'             => 'Transaction',
                'DeclineTransaction'            => 'Transaction',
                'GetTransaction'                => 'Transaction',
                'CaptureTransactionByQr'        => 'Transaction',
                'RefundTransaction'             => 'RefundOverview',
                'TokenizeTransaction'           => 'Transaction',
            ],
        ];
    }
}
