<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Transactions;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Transactions\Approve,
    RequestInterface,
    AbstractRequest
};

/**
 * Class ApproveTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Transactions
 */
class ApproveTest extends UnitTest
{
    /**
     * @var Approve
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new Approve('1234');
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
    public function testItCanSetATransactionId(): void
    {
        verify(method_exists($this->request, 'setTransactionId'))->true();
        verify($this->request->setTransactionId('1234'))->isInstanceOf(Approve::class);
    }

    /**
     * @depends testItCanSetATransactionId
     *
     * @return void
     */
    public function testItCanGetATransactionId(): void
    {
        verify(method_exists($this->request, 'getTransactionId'))->true();

        $this->request->setTransactionId('1234');

        verify($this->request->getTransactionId())->string();
        verify($this->request->getTransactionId())->notEmpty();
        verify($this->request->getTransactionId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        $this->request->setTransactionId('1234');

        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('transactions/1234/approve');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_PATCH);
    }
}