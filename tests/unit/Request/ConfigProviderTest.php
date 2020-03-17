<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request;

use CodeCeption\Test\Unit as UnitTest;
use Codeception\Lib\ConfigProviderTestTrait;
use PayNL\Sdk\Request\ConfigProvider;

/**
 * Class ConfigProviderTest
 * @package Tests\Unit\PayNL\Sdk\Request
 */
class ConfigProviderTest extends UnitTest
{
    use ConfigProviderTestTrait;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    /**
     * @return void
     */
    public function testItHasInvokableConfig(): void
    {
        $invokeConfig = ($this->configProvider)();
        $configKeys = [
            'service_manager',
            'service_loader_options',
            'request'
        ];

        $this->tester->assertArrayHasAtLeastOneOfKeys($invokeConfig, $configKeys);
        $this->tester->assertArrayCanOnlyContainKeys($invokeConfig, $configKeys);
    }

    private function testInvokedFunctionWithKeys($function, $keys): void
    {
        $this->tester->assertObjectHasMethod($function, $this->configProvider);
        $config = $this->tester->invokeMethod($this->configProvider, $function);
        verify($config)->array();
        verify($config)->notEmpty();
        $this->tester->assertArrayHasAtLeastOneOfKeys($config, $keys);
        $this->tester->assertArrayCanOnlyContainKeys($config, $keys);
    }

    /**
     * @return void
     */
    public function testItHasRequestConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getRequestConfig', [
            'aliases',
            'initializers',
            'services',
            'factories'
        ]);
    }

    /**
     * @return void
     */
    public function testItHasCurrencyServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getCurrencyServicesConfig', [
            'GetAllCurrencies',
            'GetCurrency'
        ]);
    }

    /**
     * @return void
     */
    public function testItHasDirectdebitServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getDirectdebitServicesConfig', [
            'CreateDirectdebit',
            'CreateRecurringDirectdebit',
            'DeleteDirectdebit',
            'GetDirectdebit',
            'UpdateDirectdebit'
        ]);
    }

    public function testItHasIsPayServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getIsPayServicesConfig', [
            'IsPay'
        ]);
    }

    public function testItHasMerchantServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getMerchantServicesConfig', [
            'AddTrademark',
            'DeleteTrademark',
            'GetMerchant'
        ]);
    }

    public function testItHasPinServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getPinServicesConfig', [
            'ConfirmTerminalTransaction',
            'GetReceipt',
            'GetTerminals',
            'GetTerminalTransactionStatus',
            'PayTransaction'
        ]);
    }

    public function testItHasQrServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getQrServicesConfig', [
            'DecodeQr',
            'EncodeQr',
            'ValidateQr'
        ]);
    }

    public function testItHasRefundServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getRefundServicesConfig', [
            'GetRefund'
        ]);
    }

    public function testItHasServiceServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getServiceServicesConfig', [
            'CreatePaymentLink',
            'GetService',
            'GetAllServices',
            'GetPaymentMethods'
        ]);
    }

    public function testItHasTransactionServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getTransactionServicesConfig', [
            'ApproveTransaction',
            'CancelTransaction',
            'CaptureTransaction',
            'CreateTransaction',
            'DeclineTransaction',
            'GetTransaction',
            'CaptureTransactionByQr',
            'MakeTransactionRecurring',
            'RefundTransaction',
            'TokenizeTransaction'
        ]);
    }

    public function testItHasVouchersServicesConfig(): void
    {
        $this->testInvokedFunctionWithKeys('getVouchersServicesConfig', [
            'ActivateVoucher',
            'CheckVoucherBalance',
            'ChargeVoucher'
        ]);
    }
}