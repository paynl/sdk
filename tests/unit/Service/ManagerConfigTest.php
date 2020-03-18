<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Service;

use Codeception\{
    Test\Unit as UnitTest,
    TestAsset\InvokableObject
};
use PayNL\Sdk\{
    Config\Loader as ConfigLoader,
    Service\Config as ServiceConfig,
    Service\Manager as ServiceManager,
    Service\ManagerConfig as ServiceManagerConfig
};

/**
 * Class ManagerConfigTest
 *
 * @package Tests\Unit\PayNL\Sdk\Service
 */
class ManagerConfigTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        $serviceManagerConfig = new ServiceManagerConfig();
        verify($serviceManagerConfig)->isInstanceOf(ServiceConfig::class);
        verify($serviceManagerConfig['factories'])->hasKey(ConfigLoader::class);
        verify($serviceManagerConfig['factories'][ConfigLoader::class])->object();
        verify($serviceManagerConfig['factories'][ConfigLoader::class])->callable();
        verify($serviceManagerConfig['factories'])->hasKey('ServiceManager');
        verify($serviceManagerConfig['factories']['ServiceManager'])->object();
        verify($serviceManagerConfig['factories']['ServiceManager'])->callable();
    }

    /**
     * @return void
     */
    public function testItCanConfigureAServiceManager(): void
    {
        $manager = new ServiceManager();

        $config = new ServiceManagerConfig([
            'aliases' => [
                'foo' => 'InvokableObject',
            ],
            'invokables' => [
                'InvokableObject' => InvokableObject::class,
            ],
        ]);

        $configuredManager = $config->configureServiceManager($manager);
        verify($configuredManager)->same($manager);
        verify($configuredManager->has('foo'))->true();
        verify($configuredManager->has(ServiceManager::class));
        verify($configuredManager->get(ServiceManager::class))->same($manager);

        verify($config['services'])->hasKey(ServiceManager::class);
        verify($config['services'][ServiceManager::class])->same($manager);
    }
}
