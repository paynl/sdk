<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Parameter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\Parameter\CardNumberTrait;
use ReflectionException;


/**
 * Class CardNumberTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Parameter
 */
class CardNumberTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetACardNumber(): void
    {
        /** @var CardNumberTrait $traitCls */
        $traitCls = $this->getMockForTrait(CardNumberTrait::class);

        verify(method_exists($traitCls, 'setCardNumber'))->true();

        verify($traitCls->setCardNumber('1234'))->isInstanceOf(get_class($traitCls));
    }

    /**
     * @depends testItCanSetACardNumber
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetACardNumber(): void
    {
        /** @var CardNumberTrait $traitCls */
        $traitCls = $this->getMockForTrait(CardNumberTrait::class);

        verify(method_exists($traitCls, 'getCardNumber'))->true();
        verify($traitCls->getCardNumber())->string();
        verify($traitCls->getCardNumber())->isEmpty();

        $traitCls->setCardNumber('1234');

        verify($traitCls->getCardNumber())->notEmpty();
        verify($traitCls->getCardNumber())->equals('1234');
    }
}
