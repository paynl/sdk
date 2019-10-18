<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Transactions;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Transaction;
use PayNL\Sdk\Request\{
    Transactions\Create,
    RequestInterface,
    AbstractRequest
};

/**
 * Class CreateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Transactions
 */
class CreateTest extends UnitTest
{
    /**
     * @var Create
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var Transaction $transactionMock */
        $transactionMock = $this->createMock(Transaction::class);
        $this->request = new Create($transactionMock);
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
    public function testItCanGetUri(): void
    {
        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('transactions');
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
