<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\{
    Config\ProviderInterface as ConfigProviderInterface,
    Common\ManagerFactory
};

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Model
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
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
                Manager::class => [
                    'service_manager' => 'modelManager',
                    'config_key'      => 'models',
                    'class_method'    => 'getModelConfig'
                ],
            ],
            'hydrator_collection_map' => [
                // CollectionEntity(Alias) => EntryEntity(Alias)
                'contactMethods'        => 'contactMethod',
                'currencies'            => 'currency',
                'directdebits'          => 'directdebit',
                'errors'                => 'error',
                'links'                 => 'link',
                'paymentMethods'        => 'paymentMethod',
                'products'              => 'product',
                'services'              => 'service',
                'terminals'             => 'terminal',
                'trademarks'            => 'trademark',
                'refundedTransactions'  => 'refundTransaction'
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
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getModelConfig(): array
    {
        return [
            'aliases' => [
                'address'               => 'Address',
                'amount'                => 'Amount',
                'bankAccount'           => 'BankAccount',
                'card'                  => 'Card',
                'company'               => 'Company',
                'companyCard'           => 'CompanyCard',
                'contactMethod'         => 'ContactMethod',
                'contactMethods'        => 'ContactMethods',
                'currencies'            => 'Currencies',
                'currency'              => 'Currency',
                'customer'              => 'Customer',
                'directdebit'           => 'Directdebit',
                'directdebits'          => 'Directdebits',
                'directdebitOverview'   => 'DirectdebitOverview',
                'error'                 => 'Error',
                'errors'                => 'Errors',
                'integration'           => 'Integration',
                'interval'              => 'Interval',
                'link'                  => 'Link',
                'links'                 => 'Links',
                'mandate'               => 'Mandate',
                'merchant'              => 'Merchant',
                'notification'          => 'Notification',
                'order'                 => 'Order',
                'paymentMethod'         => 'PaymentMethod',
                'paymentMethods'        => 'PaymentMethods',
                'product'               => 'Product',
                'products'              => 'Products',
                'progress'              => 'Progress',
                'qr'                    => 'Qr',
                'receipt'               => 'Receipt',
                'recurringTransaction'  => 'RecurringTransaction',
                'refund'                => 'Refund',
                'refundOverview'        => 'RefundOverview',
                'refundTransaction'     => 'RefundTransaction',
                'refundedtransactions'  => 'RefundedTransactions',
                'refunded_transactions' => 'RefundedTransactions',
                'refundedTransactions'  => 'RefundedTransactions',
                'failedTransactions'    => 'RefundedTransactions',
                'failedtransactions'    => 'RefundedTransactions',
                'failed_transactions'   => 'RefundedTransactions',
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
                'CompanyCard'           => CompanyCard::class,
                'ContactMethod'         => ContactMethod::class,
                'ContactMethods'        => ContactMethods::class,
                'Currencies'            => Currencies::class,
                'Currency'              => Currency::class,
                'Customer'              => Customer::class,
                'Directdebit'           => Directdebit::class,
                'Directdebits'          => Directdebits::class,
                'DirectdebitOverview'   => DirectdebitOverview::class,
                'Error'                 => Error::class,
                'Errors'                => Errors::class,
                'Integration'           => Integration::class,
                'Interval'              => Interval::class,
                'Link'                  => Link::class,
                'Links'                 => Links::class,
                'Mandate'               => Mandate::class,
                'Merchant'              => Merchant::class,
                'Notification'          => Notification::class,
                'Order'                 => Order::class,
                'PaymentMethod'         => PaymentMethod::class,
                'PaymentMethods'        => PaymentMethods::class,
                'Product'               => Product::class,
                'Products'              => Products::class,
                'Progress'              => Progress::class,
                'Qr'                    => Qr::class,
                'Receipt'               => Receipt::class,
                'RecurringTransaction'  => RecurringTransaction::class,
                'Refund'                => Refund::class,
                'RefundOverview'        => RefundOverview::class,
                'RefundTransaction'     => RefundTransaction::class,
                'RefundedTransactions'  => RefundedTransactions::class,
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
        ];
    }
}
