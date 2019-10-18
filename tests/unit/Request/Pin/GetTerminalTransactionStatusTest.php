<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Pin;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Pin\GetTerminalTransactionStatus,
    RequestInterface,
    AbstractRequest
};

/**
 * Class GetTerminalTransactionStatusTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Pin
 */
class GetTerminalTransactionStatusTest extends UnitTest
{
    /**
     * @var GetTerminalTransactionStatus
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new GetTerminalTransactionStatus('1234');
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
            ->isInstanceOf(GetTerminalTransactionStatus::class)
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
        verify($this->request->getUri())->equals('pin/1234/status');
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
