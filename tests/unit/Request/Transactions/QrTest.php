<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Transactions;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    Transaction,
    TransformerInterface
};
use PayNL\Sdk\Request\{
    Transactions\Qr,
    RequestInterface,
    AbstractRequest
};

/**
 * Class QRTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Transactions
 */
class QrTest extends UnitTest
{
    /**
     * @var Qr
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new Qr('1234', 'scan-data');
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
        verify($this->request->setTransactionId('1234'))->isInstanceOf(Qr::class);
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
        verify($this->request->getUri())->equals('transactions/1234/qr');
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

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        verify(method_exists($this->request, 'getTransformer'));
        verify($this->request->getTransformer())->isInstanceOf(TransformerInterface::class);
        verify($this->request->getTransformer())->isInstanceOf(Transaction::class);
    }
}
