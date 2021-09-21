<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Service;

use Codeception\{
    TestAsset\InvokableObject,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Config\Config,
    Service\Config as ServiceConfig,
    Service\Manager as ServiceManager
};

/**
 * Class ConfigTest
 *
 * @package Tests\Unit\PayNL\Sdk\Service
 */
class ConfigTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        $config = new ServiceConfig();
        verify($config)->isInstanceOf(Config::class);
    }

    /**
     * @return void
     */
    public function testNotAllowedKeysAreNotAvailable(): void
    {
        $config = new ServiceConfig([
            'foo' => [
                'bar',
                'baz'
            ],
        ]);

        verify($config)->hasKey('aliases');
        verify($config)->hasKey('factories');
        verify($config)->hasKey('initializers');
        verify($config)->hasKey('invokables');
        verify($config)->hasKey('mapping');
        verify($config)->hasKey('services');
        verify($config)->hasNotKey('foo');
    }

    /**
     * @return void
     */
    public function testItCanConfigureAServiceManager(): void
    {
        $manager = new ServiceManager();

        $config = new ServiceConfig([
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
    }
}
