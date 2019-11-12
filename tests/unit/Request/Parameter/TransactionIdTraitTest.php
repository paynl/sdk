<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Parameter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;
use ReflectionException;


/**
 * Class TransactionIdTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Parameter
 */
class TransactionIdTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetATerminalTransactionId(): void
    {
        /** @var TransactionIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(TransactionIdTrait::class);

        verify(method_exists($traitCls, 'setTransactionId'))->true();

        verify($traitCls->setTransactionId('1234'))->isInstanceOf(get_class($traitCls));
    }

    /**
     * @depends testItCanSetATerminalTransactionId
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetATerminalTransactionId(): void
    {
        /** @var TransactionIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(TransactionIdTrait::class);

        verify(method_exists($traitCls, 'getTransactionId'))->true();
        verify($traitCls->getTransactionId())->string();
        verify($traitCls->getTransactionId())->isEmpty();

        $traitCls->setTransactionId('1234');

        verify($traitCls->getTransactionId())->notEmpty();
        verify($traitCls->getTransactionId())->equals('1234');
    }
}
