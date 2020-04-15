<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\ConfigProviderTestTrait;
use PayNL\Sdk\Hydrator\ConfigProvider;

class ConfigProviderTest extends UnitTest
{
    use ConfigProviderTestTrait;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    /**
     * @return void
     */
    public function testItHasFilterConfig(): void
    {
        $this->tester->assertObjectHasMethod('getHydratorConfig', $this->configProvider);
        $config = $this->configProvider->getHydratorConfig();
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
