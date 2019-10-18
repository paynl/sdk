<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Merchants;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Merchants\DeleteTrademark,
    RequestInterface,
    AbstractRequest
};
use UnitTester;

/**
 * Class DeleteTrademarkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Merchants
 */
class DeleteTrademarkTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var DeleteTrademark
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new DeleteTrademark('1234', 'TT-0000-0000');
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->request)->isInstanceOf(RequestInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->request)->isInstanceOf(AbstractRequest::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAMerchantId(): void
    {
        verify(method_exists($this->request, 'setMerchantId'))->true();
        verify($this->request->setMerchantId('1234'))->isInstanceOf(DeleteTrademark::class);
    }

    /**
     * @depends testItCanSetAMerchantId
     *
     * @return void
     */
    public function testItCanGetAMerchantId(): void
    {
        verify(method_exists($this->request, 'getMerchantId'))->true();

        $this->request->setMerchantId('1234');

        verify($this->request->getMerchantId())->string();
        verify($this->request->getMerchantId())->notEmpty();
        verify($this->request->getMerchantId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetATrademarkId(): void
    {
        verify(method_exists($this->request, 'setTrademarkId'))->true();
        verify($this->tester->getMethodAccessibility($this->request, 'setTrademarkId'))->equals('protected');
        verify($this->tester->invokeMethod($this->request, 'setTrademarkId', ['1234']))->isInstanceOf(DeleteTrademark::class);
    }

    /**
     * @depends testItCanSetATrademarkId
     *
     * @return void
     */
    public function testItCanGetATrademarkId(): void
    {
        verify(method_exists($this->request, 'getTrademarkId'))->true();

        $this->tester->invokeMethod($this->request, 'setTrademarkId', ['1234']);

        verify($this->request->getTrademarkId())->string();
        verify($this->request->getTrademarkId())->notEmpty();
        verify($this->request->getTrademarkId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('merchants/1234/trademarks/TT-0000-0000');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_DELETE);
    }
}
