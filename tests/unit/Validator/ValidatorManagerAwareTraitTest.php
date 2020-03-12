<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use CodeCeption\Test\Unit as UnitTest;
use PayNL\Sdk\Validator\ValidatorManagerAwareTrait;
use ReflectionException;
use UnitTester;

/**
 * Class ValidatorManagerAwareTraitTest
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class ValidatorManagerAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     * @return void
     */
    public function testItCanSetValidatorManager(): void
    {
        /** @var ValidatorManagerAwareTrait $mock */
        $mock = $this->getMockForTrait(ValidatorManagerAwareTrait::class);
        verify(method_exists($mock, 'setValidatorManager'))->true();
        $validatorManagerMock = $this->tester->grabMockService('validatorManager');
        verify($mock->setValidatorManager($validatorManagerMock))->isInstanceOf(get_class($mock));
    }

    /**
     * @throws ReflectionException
     * @return void
     */
    public function testItThrowsExceptionGettingEmptyManager(): void
    {
        /** @var ValidatorManagerAwareTrait $mock */
        $mock = $this->getMockForTrait(ValidatorManagerAwareTrait::class);
        verify(method_exists($mock, 'getValidatorManager'))->true();
        $this->expectException('RuntimeException');
        $mock->getValidatorManager();
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
        $validatorManagerMock = $this->tester->grabMockService('validatorManager');
        $mock->setValidatorManager($validatorManagerMock);
        verify($mock->getValidatorManager())->isInstanceOf(get_class($validatorManagerMock));
    }
}