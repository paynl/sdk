<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Mapper;

use Codeception\{
    Lib\ManagerTestTrait,
    Test\Unit as UnitTest,
    TestAsset\Dummy,
    TestAsset\SimpleDummyMapper
};
use PayNL\Sdk\{
    Exception\MapperSourceServiceNotFoundException,
    Exception\MapperTargetServiceNotFoundException,
    Exception\ServiceNotCreatedException,
    Exception\ServiceNotFoundException,
    Mapper\MapperInterface,
    Mapper\Manager,
    Service\AbstractPluginManager
};

/**
 * Class ManagerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
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
        $this->manager = new Manager($this->tester->getServiceManager());
    }

    /**
     * @inheritDoc
     */
    public function testItIsAManager(): void
    {
        $this->traitTestItIsAManager();

        verify($this->manager)->isInstanceOf(AbstractPluginManager::class);

        $this->assertObjectHasAttribute('instanceOf', $this->manager);
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
        verify($instanceOf)->equals(MapperInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanConfigure(): void
    {
        verify($this->manager->configure([]))->isInstanceOf(Manager::class);
    }

    /**
     * @return void
     */
    public function testConfigureThrowsAnExceptionWhenMapperNotExists(): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        $this->manager->configure([
            'mapping' => [
                'NonExistingMapper' => [
                    'Foo' => 'Bar',
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testConfigureThrowsAnExceptionWhenMapperKeyIsNotCorrect(): void
    {
        $this->expectException(ServiceNotFoundException::class);
        $this->manager->configure([
            'mapping' => [
                Dummy::class => [
                    'Foo' => 'Bar',
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testConfigureThrowsAnExceptionWhenSourceCanNotBeFound(): void
    {
        $this->expectException(MapperSourceServiceNotFoundException::class);
        $this->manager->configure([
            'mapping' => [
                SimpleDummyMapper::class => [
                    'Foo' => 'Bar',
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testConfigureThrowsAnExceptionWhenTargetCanNotBeFound(): void
    {
        $this->expectException(MapperTargetServiceNotFoundException::class);
        $this->manager->configure([
            'mapping' => [
                SimpleDummyMapper::class => [
                    'Invokable' => 'Bar',
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testItExtendsTheValidateOverridesMethod(): void
    {
        $this->tester->assertClassHasMethod('validateOverrides', Manager::class);
        $this->tester->assertClassMethodIsProtected('validateOverrides', Manager::class);
    }

    /**
     * @return void
     */
    public function testItCanGetMapping(): void
    {
        $this->tester->assertObjectHasMethod('getMapping', $this->manager);
        $mapping = $this->manager->getMapping();

        verify($mapping)->array();
    }
}
