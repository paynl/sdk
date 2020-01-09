<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;
use PayNL\Sdk\Common\ManagerFactory;

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Model
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
                'modelManager' => [
                    'service_manager' => 'modelManager',
                    'config_key' => 'models',
                    'class_method' => 'getModels'
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
                'modelManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        return [
            'aliases' => [
                'address'               => 'Address',
                'amount'                => 'Amount',
                'bankAccount'           => 'BankAccount',
                'card'                  => 'Card',
                'company'               => 'Company',
                'contactMethod'         => 'ContactMethod',
                'contactMethods'        => 'ContactMethods',
                'currencies'            => 'Currencies',
                'currency'              => 'Currency',
                'customer'              => 'Customer',
                'directdebit'           => 'Directdebit',
                'error'                 => 'Error',
                'errors'                => 'Errors',
                'integration'           => 'Integration',
                'interval'              => 'Interval',
                'link'                  => 'Link',
                'links'                 => 'Links',
                'mandate'               => 'Mandate',
                'merchant'              => 'Merchant',
                'order'                 => 'Order',
                'paymentMethod'         => 'PaymentMethod',
                'product'               => 'Product',
                'products'              => 'Products',
                'progress'              => 'Progress',
                'qr'                    => 'Qr',
                'receipt'               => 'Receipt',
                'recurringTransaction'  => 'RecurringTransaction',
                'refund'                => 'Refund',
                'service'               => 'Service',
                'services'              => 'Services',
                'servicePaymentLink'    => 'ServicePaymentLink',
                'statistics'            => 'Statistics',
                'status'                => 'Status',
                'terminal'              => 'Terminal',
                'terminals'             => 'Terminals',
                'terminalTransaction'   => 'TerminalTransaction',
                'trademark'             => 'Trademark',
                'trademarks'            => 'Trademarks',
                'transaction'           => 'Transaction',
                'transactionStatus'     => 'TransactionStatus',
                'transfer'              => 'Transfer',
                'voucher'               => 'Voucher',
            ],
            'invokables' => [
                'Address'               => Address::class,
                'Amount'                => Amount::class,
                'BankAccount'           => BankAccount::class,
                'Card'                  => Card::class,
                'Company'               => Company::class,
                'ContactMethod'         => ContactMethod::class,
                'ContactMethods'        => ContactMethods::class,
                'Currencies'            => Currencies::class,
                'Currency'              => Currency::class,
                'Customer'              => Customer::class,
                'Directdebit'           => Directdebit::class,
                'Error'                 => Error::class,
                'Errors'                => Errors::class,
                'Integration'           => Integration::class,
                'Interval'              => Interval::class,
                'Link'                  => Link::class,
                'Links'                 => Links::class,
                'Mandate'               => Mandate::class,
                'Merchant'              => Merchant::class,
                'Order'                 => Order::class,
                'PaymentMethod'         => PaymentMethod::class,
                'Product'               => Product::class,
                'Products'              => Products::class,
                'Progress'              => Progress::class,
                'Qr'                    => Qr::class,
                'Receipt'               => Receipt::class,
                'RecurringTransaction'  => RecurringTransaction::class,
                'Refund'                => Refund::class,
                'Service'               => Service::class,
                'Services'              => Services::class,
                'ServicePaymentLink'    => ServicePaymentLink::class,
                'Statistics'            => Statistics::class,
                'Status'                => Status::class,
                'Terminal'              => Terminal::class,
                'Terminals'             => Terminals::class,
                'TerminalTransaction'   => TerminalTransaction::class,
                'Trademark'             => Trademark::class,
                'Trademarks'            => Trademarks::class,
                'Transaction'           => Transaction::class,
                'TransactionStatus'     => TransactionStatus::class,
                'Transfer'              => Transfer::class,
                'Voucher'               => Voucher::class,
            ],
//            'mapping' => [
//                'from_request' => [
//                    Request(Alias) => Model(Alias)
//                    'GetAllCurrencies' => Currencies::class,


//                    'GetAllCurrencies'              => Currencies\GetAll::class,
//                    'GetCurrencies'                 => Currencies\Get::class,
//                    'CreateDirectdebit'             => Directdebits\Create::class,
//                    'CreateRecurringDirectdebit'    => Directdebits\CreateRecurring::class,
//                    'DeleteDirectdebit'             => Directdebits\Delete::class,
//                    'GetDirectdebit'                => Directdebits\Get::class,
//                    'UpdateDirectdebit'             => Directdebits\Update::class,
//                    'IsPay'                         => IsPay\Get::class,
//                    'AddTrademark'                  => Merchants\AddTrademark::class,
//                    'DeleteTrademark'               => Merchants\DeleteTrademark::class,
//                    'GetMerchant'                   => Merchants\Get::class,
//                    'ConfirmTerminalTransaction'    => Pin\ConfirmTerminalTransaction::class,
//                    'GetReceipt'                    => Pin\GetReceipt::class,
//                    'GetTerminals'                  => Pin\GetTerminals::class,
//                    'GetTerminalTransactionStatus'  => Pin\GetTerminalTransactionStatus::class,
//                    'PayTransaction'                => Pin\PayTransaction::class,
//                    'DecodeQr'                      => Qr\Decode::class,
//                    'EncodeQr'                      => Qr\Encode::class,
//                    'ValidateQr'                    => Qr\Validate::class,
//                    'GetRefunds'                    => Refunds\Get::class,
//                    'CreatePaymentLink'             => Services\CreatePaymentLink::class,
//                    'GetService'                    => Services\Get::class,
//                    'GetAllServices'                => Services\GetAll::class,
//                    'GetPaymentMethods'             => Services\GetPaymentMethods::class,
//                    'ApproveTransaction'            => Transactions\Approve::class,
//                    'CancelTransaction'             => Transactions\Cancel::class,
//                    'CaptureTransaction'            => Transactions\Capture::class,
//                    'CreateTransaction'             => Transactions\Create::class,
//                    'DeclineTransaction'            => Transactions\Decline::class,
//                    'GetTransaction'                => Transactions\Get::class,
//                    'CaptureTransactionByQr'        => Transactions\Qr::class,
//                    'MakeTransactionRecurring'      => Transactions\Recurring::class,
//                    'RefundTransaction'             => Transactions\Refund::class,
//                    'TokenizeTransaction'           => Transactions\Tokenize::class,
//                    'ActivateVoucher'               => Vouchers\Activate::class,
//                    'CheckVoucherBalance'           => Vouchers\Balance::class,
//                    'ChargeVoucher'                 => Vouchers\Charge::class,
//                ],
//            ],
        ];
    }
}
