<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Parameter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\Parameter\TerminalTransactionIdTrait;
use ReflectionException;


/**
 * Class TerminalTransactionIdTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Parameter
 */
class TerminalTransactionIdTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetATerminalTransactionId(): void
    {
        /** @var TerminalTransactionIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(TerminalTransactionIdTrait::class);

        verify(method_exists($traitCls, 'setTerminalTransactionId'))->true();

        verify($traitCls->setTerminalTransactionId('1234'))->isInstanceOf(get_class($traitCls));
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
        /** @var TerminalTransactionIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(TerminalTransactionIdTrait::class);

        verify(method_exists($traitCls, 'getTerminalTransactionId'))->true();
        verify($traitCls->getTerminalTransactionId())->string();
        verify($traitCls->getTerminalTransactionId())->isEmpty();

        $traitCls->setTerminalTransactionId('1234');

        verify($traitCls->getTerminalTransactionId())->notEmpty();
        verify($traitCls->getTerminalTransactionId())->equals('1234');
    }
}
