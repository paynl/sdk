<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Pin;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    Receipt,
    TransformerInterface
};
use PayNL\Sdk\Request\{
    Pin\GetReceipt,
    RequestInterface,
    AbstractRequest
};

/**
 * Class GetReceiptTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Pin
 */
class GetReceiptTest extends UnitTest
{
    /**
     * @var GetReceipt
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new GetReceipt('1234');
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
            ->isInstanceOf(GetReceipt::class)
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
        verify($this->request->getUri())->equals('pin/1234/receipt');
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

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        verify(method_exists($this->request, 'getTransformer'));
        verify($this->request->getTransformer())->isInstanceOf(TransformerInterface::class);
        verify($this->request->getTransformer())->isInstanceOf(Receipt::class);
    }
}
