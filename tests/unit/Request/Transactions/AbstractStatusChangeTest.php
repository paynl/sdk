<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Transactions;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    Transaction,
    TransformerInterface
};
use PayNL\Sdk\Request\{
    Transactions\AbstractStatusChange,
    RequestInterface,
    AbstractRequest
};
use PayNL\Sdk\Exception\InvalidArgumentException;
use UnitTester;

/**
 * Class AbstractStatusChangeTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Transactions
 */
class AbstractStatusChangeTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractStatusChange
     */
    protected $anonymousClassFromAbstract;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class() extends AbstractStatusChange {
        };

    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(RequestInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractRequest::class);
    }

    /**
     * @return void
     */
    public function testItCanSetATransactionId(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'setTransactionId'))->true();
        verify($this->anonymousClassFromAbstract->setTransactionId('1234'))->isInstanceOf(AbstractStatusChange::class);
    }

    /**
     * @depends testItCanSetATransactionId
     *
     * @return void
     */
    public function testItCanGetATransactionId(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getTransactionId'))->true();

        $this->anonymousClassFromAbstract->setTransactionId('1234');

        verify($this->anonymousClassFromAbstract->getTransactionId())->string();
        verify($this->anonymousClassFromAbstract->getTransactionId())->notEmpty();
        verify($this->anonymousClassFromAbstract->getTransactionId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetAStatus(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'setStatus'))->true();
        verify($this->tester->getMethodAccessibility($this->anonymousClassFromAbstract, 'setStatus'))
            ->equals('protected')
        ;
        verify($this->tester->invokeMethod($this->anonymousClassFromAbstract, 'setStatus', ['approve']))
            ->isInstanceOf(AbstractStatusChange::class)
        ;
    }

    /**
     * @depends testItCanSetAStatus
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenSettingAnInvalidStatus(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'setStatus', ['bogus']);
    }

    /**
     * @depends testItCanSetAStatus
     *
     * @return void
     */
    public function testItCanGetAStatus(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getStatus'))->true();

        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'setStatus', ['approve']);

        verify($this->anonymousClassFromAbstract->getStatus())->string();
        verify($this->anonymousClassFromAbstract->getStatus())->notEmpty();
        verify($this->anonymousClassFromAbstract->getStatus())->equals('approve');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        $this->anonymousClassFromAbstract->setTransactionId('1234');
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'setStatus', ['void']);

        verify($this->anonymousClassFromAbstract->getUri())->string();
        verify($this->anonymousClassFromAbstract->getUri())->notEmpty();
        verify($this->anonymousClassFromAbstract->getUri())->equals('transactions/1234/void');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->anonymousClassFromAbstract->getMethod())->string();
        verify($this->anonymousClassFromAbstract->getMethod())->notEmpty();
        verify($this->anonymousClassFromAbstract->getMethod())->equals(RequestInterface::METHOD_PATCH);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getTransformer'));
        verify($this->anonymousClassFromAbstract->getTransformer())->isInstanceOf(TransformerInterface::class);
        verify($this->anonymousClassFromAbstract->getTransformer())->isInstanceOf(Transaction::class);
    }
}
