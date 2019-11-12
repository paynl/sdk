<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Parameter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\Parameter\MerchantIdTrait;
use ReflectionException;


/**
 * Class MerchantIdTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Parameter
 */
class MerchantIdTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetAMerchantId(): void
    {
        /** @var MerchantIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(MerchantIdTrait::class);

        verify(method_exists($traitCls, 'setMerchantId'))->true();

        verify($traitCls->setMerchantId('1234'))->isInstanceOf(get_class($traitCls));
    }

    /**
     * @depends testItCanSetAMerchantId
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetAMerchantId(): void
    {
        /** @var MerchantIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(MerchantIdTrait::class);

        verify(method_exists($traitCls, 'getMerchantId'))->true();
        verify($traitCls->getMerchantId())->string();
        verify($traitCls->getMerchantId())->isEmpty();

        $traitCls->setMerchantId('1234');

        verify($traitCls->getMerchantId())->notEmpty();
        verify($traitCls->getMerchantId())->equals('1234');
    }
}
