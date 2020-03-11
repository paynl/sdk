<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\ConfigProviderTestTrait;
use PayNL\Sdk\Filter\ConfigProvider;

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
        $this->tester->assertObjectHasMethod('getFilterConfig', $this->configProvider);
        $config = $this->configProvider->getFilterConfig();
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
