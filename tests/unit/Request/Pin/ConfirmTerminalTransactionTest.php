<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Pin;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Pin\ConfirmTerminalTransaction,
    RequestInterface,
    AbstractRequest
};

/**
 * Class ConfirmTerminalTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Pin
 */
class ConfirmTerminalTransactionTest extends UnitTest
{
    /**
     * @var ConfirmTerminalTransaction
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new ConfirmTerminalTransaction('1234', 'test@pay.nl', 'nl');
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
    public function testItCanSetATerminalTransactionId(): void
    {
        verify(method_exists($this->request, 'setTerminalTransactionId'))->true();
        verify($this->request->setTerminalTransactionId('1234'))
            ->isInstanceOf(ConfirmTerminalTransaction::class)
        ;
    }

    /**
     * @depends testItCanSetATerminalTransactionId
     *
     * @return void
     */
    public function testItCanGetATerminalTransactionId(): void
    {
        verify(method_exists($this->request, 'getTerminalTransactionId'))->true();

        $this->request->setTerminalTransactionId('1234');

        verify($this->request->getTerminalTransactionId())->string();
        verify($this->request->getTerminalTransactionId())->notEmpty();
        verify($this->request->getTerminalTransactionId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        $this->request->setTerminalTransactionId('1234');

        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('pin/1234/confirm');
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
