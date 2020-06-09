<?php

declare(strict_types=1);

namespace Tests\PayNL\Sdk\unit\Model\Member;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    Amount,
    Member\AmountAwareTrait
};
use UnitTester,
    ReflectionException;

/**
 * Class AmountAwareTraitTest
 *
 * @package Tests\PayNL\Sdk\unit\Model\Member
 */
class AmountAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetAmount(): void
    {
        /** @var AmountAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(AmountAwareTrait::class);

        $this->tester->assertObjectHasMethod('setAmount', $traitCls);
        $this->tester->assertObjectMethodIsPublic('setAmount', $traitCls);

        /** @var Amount $amount */
        $amount = $this->tester->grabService('modelManager')->get('Amount');

        $result = $traitCls->setAmount($amount);
        verify($result)->isInstanceOf(get_class($traitCls));
        verify($result)->same($traitCls);
    }

    /**
     * @depends testItCanSetAmount
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetAmount(): void
    {
        /** @var AmountAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(AmountAwareTrait::class);

        $this->tester->assertObjectHasMethod('getAmount', $traitCls);
        $this->tester->assertObjectMethodIsPublic('getAmount', $traitCls);

        $amount = $traitCls->getAmount();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount->getAmount())->equals(0);
        verify($amount->getCurrency())->equals('EUR');

        /** @var Amount $amountModel */
        $amountModel = $this->tester->grabService('modelManager')->get('Amount');
        $amountModel->setAmount(100);
        $amountModel->setCurrency('USD');
        $traitCls->setAmount($amountModel);

        $result = $traitCls->getAmount();
        verify($result)->isInstanceOf(Amount::class);
        verify($result)->same($amountModel);
        verify($result)->notSame($amount);
    }
}
