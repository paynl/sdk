<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\Sdk\{Common\DebugAwareInitializer,
    Config\ProviderInterface as ConfigProviderInterface,
    Common\ManagerFactory};

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Request
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
                'requestManager' => [
                    'service_manager' => 'requestManager',
                    'config_key'      => 'requests',
                    'class_method'    => 'getRequests'
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
                'requestManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getRequests(): array
    {
        return [
            'initializers' => [
                DebugAwareInitializer::class,
            ],
            'aliases' => [
                'GetAllCurrencies'              => Currencies\GetAll::class,
                'GetCurrency'                   => Currencies\Get::class,
                'CreateDirectdebit'             => Directdebits\Create::class,
                'CreateRecurringDirectdebit'    => Directdebits\CreateRecurring::class,
                'DeleteDirectdebit'             => Directdebits\Delete::class,
                'GetDirectdebit'                => Directdebits\Get::class,
                'UpdateDirectdebit'             => Directdebits\Update::class,
                'IsPay'                         => IsPay\Get::class,
                'AddTrademark'                  => Merchants\AddTrademark::class,
                'DeleteTrademark'               => Merchants\DeleteTrademark::class,
                'GetMerchant'                   => Merchants\Get::class,
                'ConfirmTerminalTransaction'    => Pin\ConfirmTerminalTransaction::class,
                'GetReceipt'                    => Pin\GetReceipt::class,
                'GetTerminals'                  => Pin\GetTerminals::class,
                'GetTerminalTransactionStatus'  => Pin\GetTerminalTransactionStatus::class,
                'PayTransaction'                => Pin\PayTransaction::class,
                'DecodeQr'                      => Qr\Decode::class,
                'EncodeQr'                      => Qr\Encode::class,
                'ValidateQr'                    => Qr\Validate::class,
                'GetRefunds'                    => Refunds\Get::class,
                'CreatePaymentLink'             => Services\CreatePaymentLink::class,
                'GetService'                    => Services\Get::class,
                'GetAllServices'                => Services\GetAll::class,
                'GetPaymentMethods'             => Services\GetPaymentMethods::class,
                'ApproveTransaction'            => Transactions\Approve::class,
                'CancelTransaction'             => Transactions\Cancel::class,
                'CaptureTransaction'            => Transactions\Capture::class,
                'CreateTransaction'             => Transactions\Create::class,
                'DeclineTransaction'            => Transactions\Decline::class,
                'GetTransaction'                => Transactions\Get::class,
                'CaptureTransactionByQr'        => Transactions\Qr::class,
                'MakeTransactionRecurring'      => Transactions\Recurring::class,
                'RefundTransaction'             => Transactions\Refund::class,
                'TokenizeTransaction'           => Transactions\Tokenize::class,
                'ActivateVoucher'               => Vouchers\Activate::class,
                'CheckVoucherBalance'           => Vouchers\Balance::class,
                'ChargeVoucher'                 => Vouchers\Charge::class,
            ],
            'factories' => [
                Currencies\GetAll::class                => Factory::class,
                Currencies\Get::class                   => Factory::class,
                Directdebits\Create::class              => Factory::class,
                Directdebits\CreateRecurring::class     => Factory::class,
                Directdebits\Delete::class              => Factory::class,
                Directdebits\Get::class                 => Factory::class,
                Directdebits\Update::class              => Factory::class,
                IsPay\Get::class                        => Factory::class,
                Merchants\AddTrademark::class           => Factory::class,
                Merchants\DeleteTrademark::class        => Factory::class,
                Merchants\Get::class                    => Factory::class,
                Pin\ConfirmTerminalTransaction::class   => Factory::class,
                Pin\GetReceipt::class                   => Factory::class,
                Pin\GetTerminals::class                 => Factory::class,
                Pin\GetTerminalTransactionStatus::class => Factory::class,
                Pin\PayTransaction::class               => Factory::class,
                Qr\Decode::class                        => Factory::class,
                Qr\Encode::class                        => Factory::class,
                Qr\Validate::class                      => Factory::class,
                Refunds\Get::class                      => Factory::class,
                Services\CreatePaymentLink::class       => Factory::class,
                Services\Get::class                     => Factory::class,
                Services\GetAll::class                  => Factory::class,
                Services\GetPaymentMethods::class       => Factory::class,
                Transactions\Approve::class             => Factory::class,
                Transactions\Cancel::class              => Factory::class,
                Transactions\Capture::class             => Factory::class,
                Transactions\Create::class              => Factory::class,
                Transactions\Decline::class             => Factory::class,
                Transactions\Get::class                 => Factory::class,
                Transactions\Qr::class                  => Factory::class,
                Transactions\Recurring::class           => Factory::class,
                Transactions\Refund::class              => Factory::class,
                Transactions\Tokenize::class            => Factory::class,
                Vouchers\Activate::class                => Factory::class,
                Vouchers\Balance::class                 => Factory::class,
                Vouchers\Charge::class                  => Factory::class,
            ],
        ];
    }
}
