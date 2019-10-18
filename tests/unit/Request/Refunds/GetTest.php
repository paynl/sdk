<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Refunds;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Refunds\Get,
    RequestInterface,
    AbstractRequest
};

/**
 * Class GetTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Refunds
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
    public function testItCanSetARefundId(): void
    {
        verify(method_exists($this->request, 'setRefundId'))->true();
        verify($this->request->setRefundId('1234'))->isInstanceOf(Get::class);
    }

    /**
     * @depends testItCanSetARefundId
     *
     * @return void
     */
    public function testItCanGetARefundId(): void
    {
        verify(method_exists($this->request, 'getRefundId'))->true();

        $this->request->setRefundId('1234');

        verify($this->request->getRefundId())->string();
        verify($this->request->getRefundId())->notEmpty();
        verify($this->request->getRefundId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        $this->request->setRefundId('1234');

        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('refunds/1234');
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
