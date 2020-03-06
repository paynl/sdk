<?php

declare(strict_types=1);

namespace Codeception\Lib;

use PayNL\Sdk\Config\ProviderInterface;
use UnitTester;

/**
 * Class ConfigProviderTestTrait
 *
 * @package Codeception\Lib
 */
trait ConfigProviderTestTrait
{
    /**
     * @var ProviderInterface
     */
    protected $configProvider;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testItIsAProvider(): void
    {
        verify($this->configProvider)->isInstanceOf(ProviderInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsCallable(): void
    {
        verify(method_exists($this->configProvider, '__invoke'))->true();
        verify($this->configProvider)->callable();

        $calledOutput = ($this->configProvider)();
        verify($calledOutput)->array();
        verify($calledOutput)->hasKey('service_manager');
        verify($calledOutput['service_manager'])->array();
        verify($calledOutput)->hasKey('api');
        verify($calledOutput['api'])->array();
        verify($calledOutput['api'])->hasKey('url');
        verify($calledOutput['api'])->hasKey('version');
    }

    /**
     * @return void
     */
    public function testItsDependencyConfig(): void
    {
        $allowedConfigKeys = [
            'aliases',
            'factories',
            'initializers',
            'invokables',
            'mapping',
            'services',
        ];

        verify(method_exists($this->configProvider, 'getDependencyConfig'))->true();

        $configOutput = $this->configProvider->getDependencyConfig();
        verify($configOutput)->array();
        $this->tester->assertArrayHasAtLeastOneOfKeys($configOutput, $allowedConfigKeys);
        $this->tester->assertArrayCanOnlyContainKeys($configOutput, $allowedConfigKeys);
    }
}
