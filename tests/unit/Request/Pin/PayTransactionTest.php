<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Pin;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Terminal;
use PayNL\Sdk\Request\{
    Pin\PayTransaction,
    RequestInterface,
    AbstractRequest
};

/**
 * Class PayTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Pin
 */
class PayTransactionTest extends UnitTest
{
    /**
     * @var PayTransaction
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var Terminal $terminalMock */
        $terminalMock = $this->createMock(Terminal::class);
        $this->request = new PayTransaction('1234', $terminalMock);
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
        verify($this->request->setTransactionId('1234'))
            ->isInstanceOf(PayTransaction::class)
        ;
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
        verify($this->request->getUri())->equals('pin/1234/payment');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_POST);
    }
}
