<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use Codeception\Lib\ManagerTestTrait;
use CodeCeption\Test\Unit as UnitTest;
use Codeception\TestAsset\DummyValidation;
use Codeception\TestAsset\DummyValidationDefault;
use PayNL\Sdk\Exception\RuntimeException;
use PayNL\Sdk\Validator\Manager;
use PayNL\Sdk\Service\AbstractPluginManager;
use PayNL\Sdk\Validator\ValidatorInterface;

/**
 * Class ManagerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class ManagerTest extends UnitTest
{
    use ManagerTestTrait {
        testItIsAManager as traitTestItIsAManager;
    }

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->manager = new Manager();
    }

    /**
     * @inheritDoc
     */
    public function testItIsAManager(): void
    {
        $this->traitTestItIsAManager();
        verify($this->manager)->isInstanceOf(AbstractPluginManager::class);
        self::assertObjectHasAttribute('instanceOf', $this->manager);
    }

    /**
     * @return void
     */
    public function testItHasADefinedInstanceOfAttribute(): void
    {
        /** @var string $instanceOf */
        $instanceOf = $this->tester->invokeMethod($this->manager, 'getInstanceOf');
        verify($instanceOf)->string();
        verify($instanceOf)->notEmpty();
        verify($instanceOf)->equals(ValidatorInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanGetCustomValidatorByRequest(): void
    {
        $this->manager->configure(
            [
                'invokables' => [
                    'DecodeQr' => DummyValidation::class
                ],
            ]
        );

        $requestMock = $this->tester->grabService('requestManager')
            ->get(
                'Request',
                [
                    'uri' => 'foo/bar',
                    'validator' => DummyValidation::class
                ]
            );

        $validator = $this->manager->getValidatorByRequest($requestMock);

        self::assertInstanceOf(DummyValidation::class, $validator);
    }

    /**
     * @return void
     */
    public function testItCanGetDefaultValidatorByRequest(): void
    {
        $this->manager->configure(
            [
                'invokables' => [
                    'RequiredMembers' => DummyValidationDefault::class
                ],
            ]
        );

        $requestMock = $this->tester->grabService('requestManager')
            ->get(
                'Request',
                [
                    'uri' => 'foo/bar',
                ]
            );

        $validator = $this->manager->getValidatorByRequest($requestMock);

        self::assertInstanceOf(DummyValidationDefault::class, $validator);
    }

    /**
     * @return void
     */
    public function testItCanThrowRuntimeException(): void
    {
        $requestMock = $this->tester->grabService('requestManager')
            ->get(
                'Request',
                [
                    'uri' => 'foo/bar',
                    'validator' => DummyValidation::class
                ]
            );

        $this->expectException(RuntimeException::class);
        $this->manager->getValidatorByRequest($requestMock);
    }

    /**
     * @return void
     */
    public function testItCanGetByCallable(): void
    {
        $requestMock = $this->tester->grabService('requestManager')
            ->get(
                'Request',
                [
                    'uri' => 'foo/bar',
                    'validator' => static function () {
                        return new DummyValidation();
                    }
                ]
            );

        $validator = $this->manager->getValidatorByRequest($requestMock);

        self::assertInstanceOf(DummyValidation::class, $validator);
    }
}
