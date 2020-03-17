<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use CodeCeption\Test\Unit as UnitTest;
use Codeception\Lib\ConfigProviderTestTrait;
use PayNL\Sdk\Transformer\ConfigProvider;

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

    public function testItHasTransformerConfig(): void
    {
        $this->tester->assertObjectHasMethod('getTransformerConfig', $this->configProvider);
        $config = $this->configProvider->getTransformerConfig();
        verify($config)->array();
        verify($config)->notEmpty();

        $configKeys = [
            'aliases',
            'factories'
        ];

        $this->tester->assertArrayHasAtLeastOneOfKeys($config, $configKeys);
        $this->tester->assertArrayCanOnlyContainKeys($config, $configKeys);
    }
}