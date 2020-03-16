<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Mapper;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\ConfigProviderTestTrait;
use PayNL\Sdk\Mapper\ConfigProvider;

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
    public function testItHasMapperConfig(): void
    {
        $this->tester->assertObjectHasMethod('getMapperConfig', $this->configProvider);
        $config = $this->configProvider->getMapperConfig();
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

    public function testItCanGetAMapConfiguration(): void
    {
        $this->tester->assertObjectHasMethod('getMap', $this->configProvider);

        $mapConfiguration = $this->configProvider->getMap();
        verify($mapConfiguration)->array();
        verify($mapConfiguration)->notEmpty();
        verify($mapConfiguration)->hasKey('RequestModelMapper');
        verify($mapConfiguration['RequestModelMapper'])->array();
        verify($mapConfiguration['RequestModelMapper'])->notEmpty();
    }
}
