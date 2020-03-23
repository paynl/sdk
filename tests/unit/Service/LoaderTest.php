<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Service;

use Codeception\Test\Unit as UnitTest;
use Codeception\TestAsset\Dummy;
use Codeception\TestAsset\DummyFactory;
use Codeception\TestAsset\DummyService;
use PayNL\Sdk\Config\Config;
use PayNL\Sdk\Exception\RuntimeException;
use PayNL\Sdk\Exception\ServiceNotFoundException;
use PayNL\Sdk\Service\Loader;
use PayNL\Sdk\Service\Config as ServiceConfig;
use PayNL\Sdk\Service\Manager as ServiceManager;
use UnitTester, Mockery, Exception;

/**
 * Class LoaderTest
 *
 * @package Tests\Unit\PayNL\Sdk\Service
 */
class LoaderTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Loader
     */
    protected $loader;

    protected $serviceConfigMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->serviceConfigMock = Mockery::spy(ServiceConfig::class);
        $this->loader = new Loader($this->tester->getServiceManager(), $this->serviceConfigMock);
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->loader)->isInstanceOf(Loader::class);

        verify(new Loader($this->tester->getServiceManager()))->isInstanceOf(Loader::class);
    }

    /**
     * @return void
     */
    public function testItCanSetDefaultServiceConfig(): void
    {
        $this->tester->assertObjectHasMethod('setDefaultServiceConfig', $this->loader);

        verify($this->loader->setDefaultServiceConfig($this->serviceConfigMock))->same($this->loader);
    }

    /**
     * @return void
     */
    public function testItCanAddAServiceManager(): void
    {
        $this->tester->assertObjectHasMethod('addServiceManager', $this->loader);

        $loader = $this->loader->addServiceManager('foo', 'bar', 'bazMethod');
        verify($loader)->isInstanceOf(Loader::class);
        verify($loader)->same($this->loader);

        $serviceManagerMock = Mockery::mock(ServiceManager::class);
        $loader = $this->loader->addServiceManager($serviceManagerMock, 'corge', 'graultMethod');
        verify($loader)->isInstanceOf(Loader::class);
        verify($loader)->same($this->loader);

        $serviceManagerMock = Mockery::mock(ServiceManager::class);
        $loader = $this->loader->addServiceManager($serviceManagerMock, 'service_manager', 'garplyMethod');
        verify($loader)->isInstanceOf(Loader::class);
        verify($loader)->same($this->loader);
    }

    public function testAddServiceManagerThrowsAnExceptionForInvalidArgument(): void
    {
        $this->expectException(RuntimeException::class);
        $this->loader->addServiceManager([], 'foo', 'bar');
    }

    /**
     * @return void
     */
    public function testItCanConvertServiceConfigToArray(): void
    {
        $this->tester->assertObjectHasMethod('serviceConfigToArray', $this->loader);
        $this->tester->assertObjectMethodIsProtected('serviceConfigToArray', $this->loader);

        $output = $this->tester->invokeMethod($this->loader, 'serviceConfigToArray', [ServiceConfig::class]);
        verify($output)->array();

        $output = $this->tester->invokeMethod($this->loader, 'serviceConfigToArray', [$this->serviceConfigMock]);
        verify($output)->array();
    }

    /**
     * @depends testItCanConvertServiceConfigToArray
     *
     * @return void
     */
    public function testItCanPreLoad(): void
    {
        try {
            $this->loader->preLoad();
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @depends testItCanConvertServiceConfigToArray
     * @depends testItCanAddAServiceManager
     * @depends testItCanPreLoad
     *
     * @return void
     */
    public function testItCanMergeServiceConfig(): void
    {
        $this->tester->assertObjectHasMethod('mergeServiceConfig', $this->loader);
        $this->tester->assertObjectMethodIsProtected('mergeServiceConfig', $this->loader);

        $this->loader->addServiceManager('foo', 'dummies', 'baz');
        $this->loader->preLoad();

        $serviceConfig = $this->tester->invokeMethod($this->loader, 'mergeServiceConfig', [
            'foo',
            [
                'service_manager' => 'corge',
                'config_key'      => 'dummies',
                'class_method'    => 'grault',
            ],
            [
                'dummies' => [
                    'invokables' => [
                        'Dummy2' => Dummy::class,
                    ],
                ],
            ]
        ]);

        verify($serviceConfig)->isInstanceOf(Config::class);
        verify($serviceConfig)->hasKey('invokables');
        verify($serviceConfig->get('invokables'))->notEmpty();
        verify($serviceConfig->get('invokables'))->hasKey('Dummy2');
        verify($serviceConfig->get('invokables'))->contains(Dummy::class);
    }

    /**
     * @depends testItCanMergeServiceConfig
     * @depends testItCanAddAServiceManager
     * @depends testItCanPreLoad
     *
     * @return void
     */
    public function testItCanLoad(): void
    {
        $this->loader->addServiceManager('foo', 'dummies', 'baz');
        $this->loader->preLoad();

        try {
            $this->loader->load();
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @depends testItCanMergeServiceConfig
     *
     * @return void
     */
    public function testLoadThrowsAnExceptionWhenServiceManagerCanNotBeFound(): void
    {
        $this->expectException(ServiceNotFoundException::class);
        /** @var ServiceManager $sm */
        $sm = $this->tester->getServiceManager();
        $sm->setService('corge', (new DummyService()));

        $loader = new Loader($this->tester->getServiceManager());
        $loader->addServiceManager('corge', 'grault', 'garply');

        $loader->preLoad();
        $loader->load();
    }
}
