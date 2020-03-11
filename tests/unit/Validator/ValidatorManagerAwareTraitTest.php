<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use CodeCeption\Test\Unit as UnitTest;
use PayNL\Sdk\Validator\Manager;
use PayNL\Sdk\Validator\ValidatorManagerAwareTrait;
use ReflectionException;

/**
 * Class ValidatorManagerAwareTraitTest
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class ValidatorManagerAwareTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     * @return void
     */
    public function testItCanSetValidatorManager(): void
    {
        /** @var ValidatorManagerAwareTrait $mock */
        $mock = $this->getMockForTrait(ValidatorManagerAwareTrait::class);
        verify(method_exists($mock, 'setValidatorManager'))->true();
        verify($mock->setValidatorManager(new Manager()))->isInstanceOf(ValidatorManagerAwareTrait::class);
    }

    /**
     * @depends testItCanSetValidatorManager
     * @return void
     * @throws ReflectionException
     */
    public function testItCanGetValidatorManager(): void
    {
        /** @var ValidatorManagerAwareTrait $mock */
        $mock = $this->getMockForTrait(ValidatorManagerAwareTrait::class);
        verify(method_exists($mock, 'getValidatorManager'))->true();
        verify($mock->getValidatorManager())->isEmpty();
        $mock->setValidatorManager(new Manager());
        verify($mock->getValidatorManager())->isInstanceOf(Manager::class);
        verify($mock->getValidatorManager())->containsOnlyInstancesOf(Manager::class);
        verify($mock->getValidatorManager())->count(1);
    }
}