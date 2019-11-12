<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Parameter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\Parameter\ServiceIdTrait;
use ReflectionException;


/**
 * Class ServiceIdTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Parameter
 */
class ServiceIdTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetAServiceId(): void
    {
        /** @var ServiceIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(ServiceIdTrait::class);

        verify(method_exists($traitCls, 'setServiceId'))->true();

        verify($traitCls->setServiceId('1234'))->isInstanceOf(get_class($traitCls));
    }

    /**
     * @depends testItCanSetAServiceId
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetAServiceId(): void
    {
        /** @var ServiceIdTrait $traitCls */
        $traitCls = $this->getMockForTrait(ServiceIdTrait::class);

        verify(method_exists($traitCls, 'getServiceId'))->true();
        verify($traitCls->getServiceId())->string();
        verify($traitCls->getServiceId())->isEmpty();

        $traitCls->setServiceId('1234');

        verify($traitCls->getServiceId())->notEmpty();
        verify($traitCls->getServiceId())->equals('1234');
    }
}
