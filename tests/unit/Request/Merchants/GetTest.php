<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Merchants;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Merchants\Get,
    RequestInterface,
    AbstractRequest
};

/**
 * Class GetTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Merchants
 */
class GetTest extends UnitTest
{
    /**
     * @var Get
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new Get('1234');
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
        verify($this->request->setMerchantId('1234'))->isInstanceOf(Get::class);
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
    public function testItCanGetUri(): void
    {
        $this->request->setMerchantId('1234');

        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('merchants/1234');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_GET);
    }
}
