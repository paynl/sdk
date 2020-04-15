<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\{
    Lib\FactoryTestTrait,
    TestAsset\DummyPluginManager,
    TestAsset\FailingPluginManager,
    TestAsset\Dummy,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Config\Config,
    Common\ManagerFactory,
    Exception\ServiceNotCreatedException,
    Exception\ServiceNotFoundException,
    Service\AbstractPluginManager
};
use Psr\Container\ContainerInterface;
use UnitTester;

class ManagerFactoryTest extends UnitTest
{
    use FactoryTestTrait;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->factory = new ManagerFactory();
    }

    /**
     * @return void
     */
    public function testItInitiatesAnAbstractPluginManager(): void
    {
        $manager = ($this->factory)($this->tester->getServiceManager(), DummyPluginManager::class);
        verify($manager)->isInstanceOf(AbstractPluginManager::class);
    }

    /**
     * @return void
     */
    public function testInvokeThrowsExceptionMissingConfigKey(): void
    {
        $this->expectException(ServiceNotFoundException::class);

        ($this->factory)($this->tester->getServiceManager(), '\\PayNL\\Sdk\\NonExistingClassName');
    }

    /**
     * @return void
     */
    public function testInvokeThrowsException(): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        ($this->factory)($this->tester->getServiceManager(), FailingPluginManager::class);
    }

    /**
     * @return void
     */
    public function testItCanInitiateManagerWithContainerWithoutServiceLoaderAndConfig(): void
    {
        $kliko = new class() implements ContainerInterface
        {
            public function get($id)
            {
            }

            public function has($id)
            {
                return false;
            }
        };

        $manager = ($this->factory)($kliko, DummyPluginManager::class);
        verify($manager)->isInstanceOf(DummyPluginManager::class);
    }

    /**
     * @return void
     */
    public function testItCanInitiateManagerWithoutContainerAndWithoutConfigKey(): void
    {
        $container = new class() implements ContainerInterface
        {
            public function get($id)
            {
                if ('config' === $id) {
                    return new Config([
                        'service_loader_options' => [
                        ],
                    ]);
                }
            }

            public function has($id)
            {
                return 'config' === $id;
            }
        };

        $manager = ($this->factory)($container, DummyPluginManager::class);
        verify($manager)->isInstanceOf(DummyPluginManager::class);
    }

    /**
     * @return void
     */
    public function testItCanInitiateManagerWithoutContainer(): void
    {
        $container = new class() implements ContainerInterface
        {
            public function get($id)
            {
                if ('config' === $id) {
                    return new Config([
                        'service_loader_options' => [
                        ],
                        'dummies' => [
                            'invokables' => [
                                'DummyInvokable' => Dummy::class,
                            ],
                        ]
                    ]);
                }
            }

            public function has($id)
            {
                return 'config' === $id;
            }
        };

        $manager = ($this->factory)($container, DummyPluginManager::class);
        verify($manager)->isInstanceOf(DummyPluginManager::class);
        verify($manager->has('DummyInvokable'));
    }
}
