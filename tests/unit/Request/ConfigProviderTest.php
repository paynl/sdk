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
        $this->tester->assertObjectHasMethod('getRequestConfig', $this->configProvider);
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
        $this->tester->assertObjectHasMethod('getCurrencyServicesConfig', $this->configProvider);
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
        $this->tester->assertObjectHasMethod('getDirectdebitServicesConfig', $this->configProvider);
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
        $this->tester->assertObjectHasMethod('getIsPayServicesConfig', $this->configProvider);
        $this->testInvokedFunctionWithKeys('getIsPayServicesConfig', [
            'IsPay'
        ]);
    }

    public function testItHasMerchantServicesConfig(): void
    {
        $this->tester->assertObjectHasMethod('getMerchantServicesConfig', $this->configProvider);
        $this->testInvokedFunctionWithKeys('getMerchantServicesConfig', [
            'AddTrademark',
            'DeleteTrademark',
            'GetMerchant'
        ]);
    }

    public function testItHasPinServicesConfig(): void
    {
        $this->tester->assertObjectHasMethod('getPinServicesConfig', $this->configProvider);
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
        $this->tester->assertObjectHasMethod('getQrServicesConfig', $this->configProvider);
        $this->testInvokedFunctionWithKeys('getQrServicesConfig', [
            'DecodeQr',
            'EncodeQr',
            'ValidateQr'
        ]);
    }

    public function testItHasRefundServicesConfig(): void
    {
        $this->tester->assertObjectHasMethod('getRefundServicesConfig', $this->configProvider);
        $this->testInvokedFunctionWithKeys('getRefundServicesConfig', [
            'GetRefund'
        ]);
    }

    public function testItHasServiceServicesConfig(): void
    {
        $this->tester->assertObjectHasMethod('getServiceServicesConfig', $this->configProvider);
        $this->testInvokedFunctionWithKeys('getServiceServicesConfig', [
            'CreatePaymentLink',
            'GetService',
            'GetAllServices',
            'GetPaymentMethods'
        ]);
    }

    public function testItHasTransactionServicesConfig(): void
    {
        $this->tester->assertObjectHasMethod('getTransactionServicesConfig', $this->configProvider);
        $this->testInvokedFunctionWithKeys('getTransactionServicesConfig', [
            'ApproveTransaction',
            'VoidTransaction',
            'CaptureTransaction',
            'CreateTransaction',
            'DeclineTransaction',
            'GetTransaction',
            'CaptureTransactionByQr',
            'MakeTransactionRecurring',
            'RefundTransaction',
            'TokenizeTransaction',
            'CancelTransaction'
        ]);
    }

    public function testItHasVouchersServicesConfig(): void
    {
        $this->tester->assertObjectHasMethod('getVouchersServicesConfig', $this->configProvider);
        $this->testInvokedFunctionWithKeys('getVouchersServicesConfig', [
            'ActivateVoucher',
            'CheckVoucherBalance',
            'ChargeVoucher'
        ]);
    }
}
