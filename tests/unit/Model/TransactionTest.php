<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Common\DateTime,
    Model\Amount,
    Model\Integration,
    Model\Order,
    Model\PaymentMethod,
    Model\Statistics,
    Model\TransactionStatus,
    Model\Transaction,
    Model\Transfer
};
use BadMethodCallException,
    Mockery
;

/**
 * Class TransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TransactionTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Transaction
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();

        $this->model = new Transaction();
    }

    /**
     * @return void
     */
    public function testItCanSetId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        $transaction = $this->model->setId('T-0000-0001');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetId
     *
     * @return void
     */
    public function testItCanGetId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $id = $this->model->getId();
        verify($id)->string();
        verify($id)->isEmpty();

        $this->model->setId('T-0000-0001');
        $id = $this->model->getId();
        verify($id)->string();
        verify($id)->notEmpty();
        verify($id)->equals('T-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetServiceId(): void
    {
        $this->tester->assertObjectHasMethod('setServiceId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setServiceId', $this->model);

        $transaction = $this->model->setServiceId('SL-0000-0001');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetServiceId
     *
     * @return void
     */
    public function testItCanGetServiceId(): void
    {
        $this->tester->assertObjectHasMethod('getServiceId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getServiceId', $this->model);

        $serviceId = $this->model->getServiceId();
        verify($serviceId)->string();
        verify($serviceId)->isEmpty();

        $this->model->setServiceId('SL-0000-0001');
        $serviceId = $this->model->getServiceId();
        verify($serviceId)->string();
        verify($serviceId)->notEmpty();
        verify($serviceId)->equals('SL-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetDescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        $transaction = $this->model->setDescription('foo bar baz');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetDescription
     *
     * @return void
     */
    public function testItCanGetDescription(): void
    {
        $this->tester->assertObjectHasMethod('getDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDescription', $this->model);

        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->isEmpty();

        $this->model->setDescription('foo bar baz');
        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->notEmpty();
        verify($description)->equals('foo bar baz');
    }

    /**
     * @return void
     */
    public function testItCanSetMerchantReference(): void
    {
        $this->tester->assertObjectHasMethod('setMerchantReference', $this->model);
        $this->tester->assertObjectMethodIsPublic('setMerchantReference', $this->model);

        $transaction = $this->model->setMerchantReference('foo bar');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetMerchantReference
     *
     * @return void
     */
    public function testItCanGetMerchantReference(): void
    {
        $this->tester->assertObjectHasMethod('getMerchantReference', $this->model);
        $this->tester->assertObjectMethodIsPublic('getMerchantReference', $this->model);

        $merchantReference = $this->model->getMerchantReference();
        verify($merchantReference)->string();
        verify($merchantReference)->isEmpty();

        $this->model->setMerchantReference('foo bar');
        $merchantReference = $this->model->getMerchantReference();
        verify($merchantReference)->string();
        verify($merchantReference)->notEmpty();
        verify($merchantReference)->equals('foo bar');
    }

    /**
     * @return void
     */
    public function testItCanSetLanguage(): void
    {
        $this->tester->assertObjectHasMethod('setLanguage', $this->model);
        $this->tester->assertObjectMethodIsPublic('setLanguage', $this->model);

        $transaction = $this->model->setLanguage('nl');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetLanguage
     *
     * @return void
     */
    public function testItCanGetLanguage(): void
    {
        $this->tester->assertObjectHasMethod('getLanguage', $this->model);
        $this->tester->assertObjectMethodIsPublic('getLanguage', $this->model);

        $language = $this->model->getLanguage();
        verify($language)->string();
        verify($language)->isEmpty();

        $this->model->setLanguage('nl');
        $language = $this->model->getLanguage();
        verify($language)->string();
        verify($language)->notEmpty();
        verify($language)->equals('nl');
    }

    /**
     * @return void
     */
    public function testItCanSetExpiresAt(): void
    {
        $this->tester->assertObjectHasMethod('setExpiresAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExpiresAt', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $transaction = $this->model->setExpiresAt($dateTimeMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetExpiresAt
     *
     * @return void
     */
    public function testItCanGetExpiresAt(): void
    {
        $this->tester->assertObjectHasMethod('getExpiresAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExpiresAt', $this->model);

        $expiresAt = $this->model->getExpiresAt();
        verify($expiresAt)->null();

        $dateTimeMock = Mockery::mock(DateTime::class);
        $this->model->setExpiresAt($dateTimeMock);
        $expiresAt = $this->model->getExpiresAt();
        verify($expiresAt)->object();
        verify($expiresAt)->isInstanceOf(DateTime::class);
        verify($expiresAt)->same($dateTimeMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $transaction = $this->model->setAmount($amountMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetAmount
     *
     * @return void
     */
    public function testItCanGetAmount(): void
    {
        $this->tester->assertObjectHasMethod('getAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmount', $this->model);

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $this->model->setAmount($amountMock);

        $amount = $this->model->getAmount();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAmountConverted(): void
    {
        $this->tester->assertObjectHasMethod('setAmountConverted', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmountConverted', $this->model);

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $transaction = $this->model->setAmountConverted($amountMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetAmountConverted
     *
     * @return void
     */
    public function testItCanGetAmountConverted(): void
    {
        $this->tester->assertObjectHasMethod('getAmountConverted', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmountConverted', $this->model);

        $amount = $this->model->getAmountConverted();
        verify($amount)->null();

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $this->model->setAmountConverted($amountMock);

        $amount = $this->model->getAmountConverted();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAmountPaid(): void
    {
        $this->tester->assertObjectHasMethod('setAmountPaid', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmountPaid', $this->model);

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $transaction = $this->model->setAmountPaid($amountMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetAmountPaid
     *
     * @return void
     */
    public function testItCanGetAmountPaid(): void
    {
        $this->tester->assertObjectHasMethod('getAmountPaid', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmountPaid', $this->model);

        $amount = $this->model->getAmountPaid();
        verify($amount)->null();

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $this->model->setAmountPaid($amountMock);

        $amount = $this->model->getAmountPaid();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAmountRefunded(): void
    {
        $this->tester->assertObjectHasMethod('setAmountRefunded', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmountRefunded', $this->model);

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $transaction = $this->model->setAmountRefunded($amountMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetAmountRefunded
     *
     * @return void
     */
    public function testItCanGetAmountRefunded(): void
    {
        $this->tester->assertObjectHasMethod('getAmountRefunded', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmountRefunded', $this->model);

        $amount = $this->model->getAmountRefunded();
        verify($amount)->null();

        $amountMock = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $this->model->setAmountRefunded($amountMock);

        $amount = $this->model->getAmountRefunded();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetPaymentMethod(): void
    {
        $this->tester->assertObjectHasMethod('setPaymentMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPaymentMethod', $this->model);

        $paymentMethodMock = $this->tester->grabMockService('modelManager')->get(PaymentMethod::class);
        $transaction = $this->model->setPaymentMethod($paymentMethodMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetPaymentMethod
     *
     * @return void
     */
    public function testItCanGetPaymentMethod(): void
    {
        $this->tester->assertObjectHasMethod('getPaymentMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPaymentMethod', $this->model);

        $paymentMethod = $this->model->getPaymentMethod();
        verify($paymentMethod)->null();

        $paymentMethodMock = $this->tester->grabMockService('modelManager')->get(PaymentMethod::class);
        $this->model->setPaymentMethod($paymentMethodMock);
        $paymentMethod = $this->model->getPaymentMethod();
        verify($paymentMethod)->object();
        verify($paymentMethod)->isInstanceOf(PaymentMethod::class);
        verify($paymentMethod)->same($paymentMethodMock);
    }

    /**
     * @return void
     */
    public function testItCanSetReturnUrl(): void
    {
        $this->tester->assertObjectHasMethod('setReturnUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReturnUrl', $this->model);

        $transaction = $this->model->setReturnUrl('http://foo.bar');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetReturnUrl
     *
     * @return void
     */
    public function testItCanGetReturnUrl(): void
    {
        $this->tester->assertObjectHasMethod('getReturnUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReturnUrl', $this->model);

        $returnUrl = $this->model->getReturnUrl();
        verify($returnUrl)->string();
        verify($returnUrl)->isEmpty();

        $this->model->setReturnUrl('http://foo.bar');
        $returnUrl = $this->model->getReturnUrl();
        verify($returnUrl)->string();
        verify($returnUrl)->notEmpty();
        verify($returnUrl)->equals('http://foo.bar');
    }

    /**
     * @return void
     */
    public function testItCanSetExchangeUrl(): void
    {
        $this->tester->assertObjectHasMethod('setExchangeUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExchangeUrl', $this->model);

        $transaction = $this->model->setExchangeUrl('http://foo.bar');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetExchangeUrl
     *
     * @return void
     */
    public function testItCanGetExchangeUrl(): void
    {
        $this->tester->assertObjectHasMethod('getExchangeUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExchangeUrl', $this->model);

        $exchangeUrl = $this->model->getExchangeUrl();
        verify($exchangeUrl)->string();
        verify($exchangeUrl)->isEmpty();

        $this->model->setExchangeUrl('http://foo.bar');
        $exchangeUrl = $this->model->getExchangeUrl();
        verify($exchangeUrl)->string();
        verify($exchangeUrl)->notEmpty();
        verify($exchangeUrl)->equals('http://foo.bar');
    }

    /**
     * @return void
     */
    public function testItCanSetIssuerUrl(): void
    {
        $this->tester->assertObjectHasMethod('setIssuerUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setIssuerUrl', $this->model);

        $transaction = $this->model->setIssuerUrl('http://foo.bar');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetIssuerUrl
     *
     * @return void
     */
    public function testItCanGetIssuerUrl(): void
    {
        $this->tester->assertObjectHasMethod('getIssuerUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getIssuerUrl', $this->model);

        $issuerUrl = $this->model->getIssuerUrl();
        verify($issuerUrl)->string();
        verify($issuerUrl)->isEmpty();

        $this->model->setIssuerUrl('http://foo.bar');
        $issuerUrl = $this->model->getIssuerUrl();
        verify($issuerUrl)->string();
        verify($issuerUrl)->notEmpty();
        verify($issuerUrl)->equals('http://foo.bar');
    }

    /**
     * @return void
     */
    public function testItCanSetTransfer(): void
    {
        $this->tester->assertObjectHasMethod('setTransfer', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTransfer', $this->model);

        $transferMock = $this->tester->grabMockService('modelManager')->get(Transfer::class);
        $transaction = $this->model->setTransfer($transferMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetTransfer
     *
     * @return void
     */
    public function testItCanGetTransfer(): void
    {
        $this->tester->assertObjectHasMethod('getTransfer', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTransfer', $this->model);

        $transfer = $this->model->getTransfer();
        verify($transfer)->null();

        $transferMock = $this->tester->grabMockService('modelManager')->get(Transfer::class);
        $this->model->setTransfer($transferMock);
        $transfer = $this->model->getTransfer();
        verify($transfer)->object();
        verify($transfer)->isInstanceOf(Transfer::class);
        verify($transfer)->same($transferMock);
    }

    /**
     * @return void
     */
    public function testItCanSetDomainId(): void
    {
        $this->tester->assertObjectHasMethod('setDomainId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDomainId', $this->model);

        $transaction = $this->model->setDomainId('foo');
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetDomainId
     *
     * @return void
     */
    public function testItCanGetDomainId(): void
    {
        $this->tester->assertObjectHasMethod('getDomainId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDomainId', $this->model);

        $domainId = $this->model->getDomainId();
        verify($domainId)->string();
        verify($domainId)->isEmpty();

        $this->model->setDomainId('foo');
        $domainId = $this->model->getDomainId();
        verify($domainId)->string();
        verify($domainId)->notEmpty();
        verify($domainId)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetIntegration(): void
    {
        $this->tester->assertObjectHasMethod('setIntegration', $this->model);
        $this->tester->assertObjectMethodIsPublic('setIntegration', $this->model);

        $integrationMock = $this->tester->grabMockService('modelManager')->get(Integration::class);
        $transaction = $this->model->setIntegration($integrationMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetIntegration
     *
     * @return void
     */
    public function testItCanGetIntegration(): void
    {
        $this->tester->assertObjectHasMethod('getIntegration', $this->model);
        $this->tester->assertObjectMethodIsPublic('getIntegration', $this->model);

        $integration = $this->model->getIntegration();
        verify($integration)->null();

        $integrationMock = $this->tester->grabMockService('modelManager')->get(Integration::class);
        $this->model->setIntegration($integrationMock);
        $integration = $this->model->getIntegration();
        verify($integration)->object();
        verify($integration)->isInstanceOf(Integration::class);
        verify($integration)->same($integrationMock);
    }

    /**
     * @return void
     */
    public function testItCanSetOrder(): void
    {
        $this->tester->assertObjectHasMethod('setOrder', $this->model);
        $this->tester->assertObjectMethodIsPublic('setOrder', $this->model);

        $orderMock = $this->tester->grabMockService('modelManager')->get(Order::class);
        $transaction = $this->model->setOrder($orderMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetOrder
     *
     * @return void
     */
    public function testItCanGetOrder(): void
    {
        $this->tester->assertObjectHasMethod('getOrder', $this->model);
        $this->tester->assertObjectMethodIsPublic('getOrder', $this->model);

        $order = $this->model->getOrder();
        verify($order)->null();

        $orderMock = $this->tester->grabMockService('modelManager')->get(Order::class);
        $this->model->setOrder($orderMock);
        $order = $this->model->getOrder();
        verify($order)->object();
        verify($order)->isInstanceOf(Order::class);
        verify($order)->same($orderMock);
    }

    /**
     * @return void
     */
    public function testItCanSetStatus(): void
    {
        $this->tester->assertObjectHasMethod('setStatus', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStatus', $this->model);

        $statusMock = $this->tester->grabMockService('modelManager')->get(TransactionStatus::class);
        $transaction = $this->model->setStatus($statusMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetStatus
     *
     * @return void
     */
    public function testItCanGetStatus(): void
    {
        $this->tester->assertObjectHasMethod('getStatus', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStatus', $this->model);

        $status = $this->model->getStatus();
        verify($status)->null();

        $statusMock = $this->tester->grabMockService('modelManager')->get(TransactionStatus::class);
        $this->model->setStatus($statusMock);
        $status = $this->model->getStatus();
        verify($status)->object();
        verify($status)->isInstanceOf(TransactionStatus::class);
        verify($status)->same($statusMock);
    }

    /**
     * @return void
     */
    public function testItCanSetStatistics(): void
    {
        $this->tester->assertObjectHasMethod('setStatistics', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStatistics', $this->model);

        $statisticsMock = $this->tester->grabMockService('modelManager')->get(Statistics::class);
        $transaction = $this->model->setStatistics($statisticsMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetStatistics
     *
     * @return void
     */
    public function testItCanGetStatistics(): void
    {
        $this->tester->assertObjectHasMethod('getStatistics', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStatistics', $this->model);

        $statistics = $this->model->getStatistics();
        verify($statistics)->null();

        $statisticsMock = $this->tester->grabMockService('modelManager')->get(Statistics::class);
        $this->model->setStatistics($statisticsMock);
        $statistics = $this->model->getStatistics();
        verify($statistics)->object();
        verify($statistics)->isInstanceOf(Statistics::class);
        verify($statistics)->same($statisticsMock);
    }

    /**
     * @return void
     */
    public function testItCanSetCreatedAt(): void
    {
        $this->tester->assertObjectHasMethod('setCreatedAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCreatedAt', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $transaction = $this->model->setCreatedAt($dateTimeMock);
        verify($transaction)->object();
        verify($transaction)->same($this->model);
    }

    /**
     * @depends testItCanSetCreatedAt
     *
     * @return void
     */
    public function testItCanGetCreatedAt(): void
    {
        $this->tester->assertObjectHasMethod('getCreatedAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCreatedAt', $this->model);

        $createdAt = $this->model->getCreatedAt();
        verify($createdAt)->object();
        verify($createdAt)->isInstanceOf(DateTime::class);

        $createdAtOld = $createdAt;

        $dateTimeMock = Mockery::mock(DateTime::class);
        $this->model->setCreatedAt($dateTimeMock);
        $createdAt = $this->model->getCreatedAt();
        verify($createdAt)->object();
        verify($createdAt)->isInstanceOf(DateTime::class);
        verify($createdAt)->same($dateTimeMock);
        verify($createdAt)->notSame($createdAtOld);
    }

    /**
     * @param int $statusCode
     *
     * @return void
     */
    private function setModelStatus(int $statusCode): void
    {
        $this->tester->assertClassHasMethod('__call', Transaction::class);

        /** @var TransactionStatus $transactionStatus */
        $transactionStatus = $this->tester->grabService('modelManager')->get(TransactionStatus::class);
        $transactionStatus->setCode($statusCode);

        $this->model->setStatus($transactionStatus);
    }

    /**
     * @return array
     */
    public function _statusCases(): array
    {
        return array_reduce([
            // array(status code, method name)
            [TransactionStatus::STATUS_CANCELLED, 'isCancelled'],
            [TransactionStatus::STATUS_PARTIALLY_REFUNDED, 'isPartiallyRefunded'],
            [TransactionStatus::STATUS_REFUNDED_CUSTOMER, 'isRefundedCustomer'],
            [TransactionStatus::STATUS_EXPIRED, 'isExpired'],
            [TransactionStatus::STATUS_REFUNDING, 'isRefunding'],
            [TransactionStatus::STATUS_CHARGEBACK, 'isChargeback'],
            [TransactionStatus::STATUS_DENIED, 'isDenied'],
            [TransactionStatus::STATUS_FAILURE, 'isFailure'],
            [TransactionStatus::STATUS_INVALID_AMOUNT, 'isInvalidAmount'],
            [TransactionStatus::STATUS_INITIALIZED, 'isInitialized'],
            [TransactionStatus::STATUS_PROCESSING, 'isProcessing'],
            [TransactionStatus::STATUS_PENDING1, 'isPending'],
            [TransactionStatus::STATUS_PENDING2, 'isPending'],
            [TransactionStatus::STATUS_PENDING3, 'isPending'],
            [TransactionStatus::STATUS_SUBSCRIPTION_OPEN, 'isSubscriptionOpen'],
            [TransactionStatus::STATUS_PROCESSED, 'isProcessed'],
            [TransactionStatus::STATUS_CONFIRMED, 'isConfirmed'],
            [TransactionStatus::STATUS_PARTIALLY_PAID, 'isPartiallyPaid'],
            [TransactionStatus::STATUS_VERIFY, 'isVerify'],
            [TransactionStatus::STATUS_AUTHORIZED, 'isAuthorized'],
            [TransactionStatus::STATUS_PARTIALLY_ACCEPTED, 'isPartiallyAccepted'],
            [TransactionStatus::STATUS_PAID, 'isPaid'],
        ], static function ($result, $item) {
            $key = $item[1] . " ({$item[0]})";
            $result[$key] = $item;
            return $result;
        }, []);
    }

    /**
     * @depends testItCanSetStatus
     *
     * @dataProvider _statusCases
     *
     * @param int $statusCode
     * @param string $methodName
     *
     * @return void
     */
    public function testItCanCheckForStatusByMethodCall(int $statusCode, string $methodName): void
    {
        $this->setModelStatus($statusCode);

        verify([$this->model, $methodName])->callable();
        verify($this->model->$methodName())->bool();
        verify($this->model->$methodName())->true();
    }

    /**
     * @depends testItCanCheckForStatusByMethodCall
     * @return void
     */
    public function testItReturnsFalseWithNoStatusSet(): void
    {
        $result = $this->model->__call('isPending');
        verify($result)->bool();
        verify($result)->false();
    }

    /**
     * @depends testItCanCheckForStatusByMethodCall
     * @return void;
     */
    public function testItReturnsFalseWithNonExistingStatusSet(): void
    {
        $result = $this->model->__call('isSomethingElse');
        verify($result)->bool();
        verify($result)->false();
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenMethodDoesNotExist(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->model->test();
    }
}
