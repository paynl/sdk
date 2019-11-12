<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Parameter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\Parameter\IncassoOrderIdTrait;
use ReflectionException;


/**
 * Class IncassoOrderIdTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Parameter
 */
class IncassoOrderIdTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetAnIncassoOrderId(): void
    {
        /** @var IncassoOrderIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(IncassoOrderIdTrait::class);

        verify(method_exists($traitCls, 'setIncassoOrderId'))->true();

        verify($traitCls->setIncassoOrderId('1234'))->isInstanceOf(get_class($traitCls));
    }

    /**
     * @depends testItCanSetAnIncassoOrderId
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetAnIncassoOrderId(): void
    {
        /** @var IncassoOrderIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(IncassoOrderIdTrait::class);

        verify(method_exists($traitCls, 'getIncassoOrderId'))->true();
        verify($traitCls->getIncassoOrderId())->string();
        verify($traitCls->getIncassoOrderId())->isEmpty();

        $traitCls->setIncassoOrderId('1234');

        verify($traitCls->getIncassoOrderId())->notEmpty();
        verify($traitCls->getIncassoOrderId())->equals('1234');
    }
}
