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
        $this->tester->assertObjectHasMethod('__invoke', $this->configProvider);
        verify($this->configProvider)->callable();

        $calledOutput = ($this->configProvider)();
        verify($calledOutput)->array();
        verify($calledOutput)->hasKey('service_manager');
        verify($calledOutput['service_manager'])->array();

        if (true === array_key_exists('service_loader_options', $calledOutput)) {
            verify($calledOutput['service_loader_options'])->array();
            foreach ($calledOutput['service_loader_options'] as $name => $settings) {
                verify($calledOutput['service_loader_options'][$name])->hasKey('service_manager');
                verify($calledOutput['service_loader_options'][$name]['service_manager'])->string();
                verify($calledOutput['service_loader_options'][$name]['service_manager'])->notEmpty();

                verify($calledOutput['service_loader_options'][$name])->hasKey('config_key');
                verify($calledOutput['service_loader_options'][$name]['config_key'])->string();
                verify($calledOutput['service_loader_options'][$name]['config_key'])->notEmpty();

                verify($calledOutput['service_loader_options'][$name])->hasKey('class_method');
                verify($calledOutput['service_loader_options'][$name]['class_method'])->string();
                verify($calledOutput['service_loader_options'][$name]['class_method'])->notEmpty();
            }
        }
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

        $this->tester->assertObjectHasMethod('getDependencyConfig', $this->configProvider);

        $configOutput = $this->configProvider->getDependencyConfig();
        verify($configOutput)->array();
        $this->tester->assertArrayHasAtLeastOneOfKeys($configOutput, $allowedConfigKeys);
        $this->tester->assertArrayCanOnlyContainKeys($configOutput, $allowedConfigKeys);
    }
}
