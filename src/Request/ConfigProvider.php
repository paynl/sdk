<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\Sdk\{Config\ProviderInterface as ConfigProviderInterface,
    Common\ManagerFactory,
    Common\DebugAwareInitializer,
    Validator\Qr\Decode,
    Validator\Qr\Encode
};

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
                Manager::class => [
                    'service_manager' => 'requestManager',
                    'config_key'      => 'requests',
                    'class_method'    => 'getRequestConfig'
                ],
            ],
            'request' => [
                'format' => RequestInterface::FORMAT_OBJECTS,
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
    public function getRequestConfig(): array
    {
        return [
            'aliases' => [
                'Request' => Request::class,
            ],
            'initializers' => [
                DebugAwareInitializer::class,
            ],
            'services' => array_merge(
                $this->getCurrencyServicesConfig(),
                $this->getDirectdebitServicesConfig(),
                $this->getIsPayServicesConfig(),
                $this->getMerchantServicesConfig(),
                $this->getPinServicesConfig(),
                $this->getQrServicesConfig(),
                $this->getRefundServicesConfig(),
                $this->getServiceServicesConfig(),
                $this->getTransactionServicesConfig(),
                $this->getVouchersServicesConfig()
            ),
            'factories' => [
                Request::class => Factory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getCurrencyServicesConfig(): array
    {
        return [
            'GetAllCurrencies' => [
                'uri' => '/currencies',
                'method' => RequestInterface::METHOD_GET,
            ],
            'GetCurrency' => [
                'uri' => '/currencies/%currencyId%',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'currencyId' => '[a-zA-Z]{3}',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getDirectdebitServicesConfig(): array
    {
        return [
            'CreateDirectdebit' => [
                'uri' => '/directdebits',
                'method' => RequestInterface::METHOD_POST,
            ],
            'CreateRecurringDirectdebit' => [
                'uri' => '/directdebits/%incassoOrderId%/debits',
                'method' => RequestInterface::METHOD_POST,
                'requiredParams' => [
                    'incassoOrderId' => 'IO(-\d{4}){3,}'
                ],
            ],
            'DeleteDirectdebit' => [
                'uri' => '/directdebits/%incassoOrderId%',
                'method' => RequestInterface::METHOD_DELETE,
                'requiredParams' => [
                    'incassoOrderId' => 'IO(-\d{4}){3,}'
                ],
            ],
            'GetDirectdebit' => [
                'uri' => '/directdebits/%incassoOrderId%',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'incassoOrderId' => 'IO(-\d{4}){3,}'
                ],
            ],
            'UpdateDirectdebit' => [
                'uri' => '/directdebits/%incassoOrderId%',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'incassoOrderId' => 'IO(-\d{4}){3,}'
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getIsPayServicesConfig(): array
    {
        return [
            'IsPay' => [
                'uri' => '/ispay/ip?value=%ip%',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'ip' => '[0-9\.]+',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getMerchantServicesConfig(): array
    {
        return [
            'AddTrademark' => [
                'uri' => '/merchants/%merchantId%/trademarks',
                'method' => RequestInterface::METHOD_POST,
                'requiredParams' => [
                    'merchantId' => 'M(-\d{4}){2,}',
                ],
            ],
            'DeleteTrademark' => [
                'uri' => '/merchants/%merchantId%/trademarks/%trademarkId%',
                'method' => RequestInterface::METHOD_DELETE,
                'requiredParams' => [
                    'merchantId' => 'M(-\d{4}){2,}',
                    'trademarkId' => 'TM(-\d{4}){2,}'
                ],
            ],
            'GetMerchant' => [
                'uri' => '/merchants/%merchantId%',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'merchantId' => 'M(-\d{4}){2,}',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getPinServicesConfig(): array
    {
        return [
            'ConfirmTerminalTransaction' => [
                'uri' => '/pin/%terminalTransactionId%/confirm',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'terminalTransactionId' => 'TT(-\d{4}){3,}',
                ],
            ],
            'GetReceipt' => [
                'uri' => '/pin/%terminalTransactionId%/receipt',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'terminalTransactionId' => 'TT(-\d{4}){3,}',
                ],
            ],
            'GetTerminals' => [
                'uri' => '/pin/terminals',
                'method' => RequestInterface::METHOD_GET,
            ],
            'GetTerminalTransactionStatus' => [
                'uri' => '/pin/%terminalTransactionId%/status',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'terminalTransactionId' => 'TT(-\d{4}){3,}',
                ],
            ],
            'PayTransaction' => [
                'uri' => '/pin/%terminalTransactionId%/payment',
                'method' => RequestInterface::METHOD_POST,
                'requiredParams' => [
                    'terminalTransactionId' => 'TT(-\d{4}){3,}',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getQrServicesConfig(): array
    {
        return [
            'DecodeQr' => [
                'uri' => '/qr/decode',
                'method' => RequestInterface::METHOD_POST,
                'validator' => Decode::class,
            ],
            'EncodeQr' => [
                'uri' => '/qr/encode',
                'method' => RequestInterface::METHOD_POST,
                'validator' => Encode::class,
            ],
            'ValidateQr' => [
                'uri' => '/qr/validate',
                'method' => RequestInterface::METHOD_POST,
                'validator' => Decode::class,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getRefundServicesConfig(): array
    {
        return [
            'GetRefund' => [
                'uri' => '/refund/%refundId%',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'refundId' => 'RF(-\d{4}){2,}',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getServiceServicesConfig(): array
    {
        return [
            'CreatePaymentLink' => [
                'uri' => '/services/%serviceId%/paymentlink',
                'method' => RequestInterface::METHOD_POST,
                'requiredParams' => [
                    'serviceId' => 'SL(-\d{4}){2,}',
                ],
            ],
            'GetService' => [
                'uri' => '/services/%serviceId%',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'serviceId' => 'SL(-\d{4}){2,}',
                ],
            ],
            'GetAllServices' => [
                'uri' => '/services',
                'method' => RequestInterface::METHOD_GET,
            ],
            'GetPaymentMethods' => [
                'uri' => '/services/%serviceId%/paymentmethods',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'serviceId' => 'SL(-\d{4}){2,}',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getTransactionServicesConfig(): array
    {
        return [
            'ApproveTransaction' => [
                'uri' => '/transactions/%transactionId%/approve',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'VoidTransaction' => [
                'uri' => '/transactions/%transactionId%/void',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'CaptureTransaction' => [
                'uri' => '/transactions/%transactionId%/capture',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'CreateTransaction' => [
                'uri' => '/transactions',
                'method' => RequestInterface::METHOD_POST,
            ],
            'DeclineTransaction' => [
                'uri' => '/transactions/%transactionId%/decline',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'GetTransaction' => [
                'uri' => '/transactions/%transactionId%',
                'method' => RequestInterface::METHOD_GET,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'CaptureTransactionByQr' => [
                'uri' => '/transactions/%transactionId%/qr',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'MakeTransactionRecurring' => [
                'uri' => '/transactions/%transactionId%/recurring',
                'method' => RequestInterface::METHOD_POST,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'RefundTransaction' => [
                'uri' => '/transactions/%transactionId%/refund',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'TokenizeTransaction' => [
                'uri' => '/transactions/%transactionId%/tokenize',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ],
            'CancelTransaction' => [
                'uri' => '/transactions/%transactionId%/cancel',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'transactionId' => 'EX(-\d{4}){3,}',
                ],
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getVouchersServicesConfig(): array
    {
        return [
            'ActivateVoucher' => [
                'uri' => '/vouchers/%cardNumber%/activate',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'cardNumber' => '\d+',
                ],
            ],
            'CheckVoucherBalance' => [
                'uri' => '/vouchers/%cardNumber%/balance',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'cardNumber' => '\d+',
                ],
            ],
            'ChargeVoucher' => [
                'uri' => '/vouchers/%cardNumber%/charge',
                'method' => RequestInterface::METHOD_PATCH,
                'requiredParams' => [
                    'cardNumber' => '\d+',
                ],
            ],
        ];
    }
}
