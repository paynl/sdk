<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\AuthAdapter;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\ConfigProviderTestTrait;
use PayNL\Sdk\AuthAdapter\ConfigProvider;

class ConfigProviderTest extends UnitTest
{
    use ConfigProviderTestTrait {
        testItIsCallable as traitTestItIsCallable;
    }

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    /**
     * @inheritDoc
     */
    public function testItIsCallable(): void
    {
        $this->traitTestItIsCallable();

        $config = ($this->configProvider)();
        $this->tester->assertArrayMustContainKeys($config, [
            'service_manager',
            'service_loader_options',
            'authentication',
        ]);

        verify($config['authentication'])->array();
        verify($config['authentication'])->notEmpty();
        verify($config['authentication'])->hasKey('type');
        verify($config['authentication']['type'])->string();
        verify($config['authentication'])->hasKey('username');
        verify($config['authentication']['username'])->string();
        verify($config['authentication'])->hasKey('password');
        verify($config['authentication']['password'])->string();
    }

    /**
     * @return void
     */
    public function testItHasAuthAdapterConfig(): void
    {
        $this->tester->assertObjectHasMethod('getAuthAdapterConfig', $this->configProvider);
        $config = $this->configProvider->getAuthAdapterConfig();
        verify($config)->array();
        verify($config)->notEmpty();

        $configKeys = [
            'aliases',
            'factories',
            'initializers',
            'invokables',
            'mapping',
            'services',
        ];

        $this->tester->assertArrayHasAtLeastOneOfKeys($config, $configKeys);
        $this->tester->assertArrayCanOnlyContainKeys($config, $configKeys);
    }
}
