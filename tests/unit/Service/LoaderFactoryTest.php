<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Service;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\FactoryTestTrait;
use PayNL\Sdk\Exception\ServiceNotCreatedException;
use PayNL\Sdk\Service\LoaderFactory;
use PayNL\Sdk\Service\Loader;
use PayNL\Sdk\Config\Config;
use UnitTester, Exception;

/**
 * Class LoaderFactoryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Service
 */
class LoaderFactoryTest extends UnitTest
{
    use FactoryTestTrait {
        testItIsCallable as traitTestItIsCallable;
    }

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->factory = new LoaderFactory();
    }

    /**
     * @return void
     */
    public function testItCanValidatePluginManagerOptions(): void
    {
        $this->tester->assertObjectHasMethod('validatePluginManagerOptions', $this->factory);
        $this->tester->assertObjectMethodIsPrivate('validatePluginManagerOptions', $this->factory);

        try {
            $config = new Config([
                'service_manager' => 'foo',
                'config_key'      => 'bar',
                'class_method'    => 'bazMethod',
            ]);

            $this->tester->invokeMethod($this->factory, 'validatePluginManagerOptions', [$config, 'foo']);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @return void
     */
    public function testValidatePluginManagerOptionsThrowsExceptionWhenServiceManagerKeyNotExists(): void
    {
        $config = new Config([
            'config_key'      => 'bar',
            'class_method'    => 'bazMethod',
        ]);

        $this->expectException(ServiceNotCreatedException::class);
        $this->tester->invokeMethod($this->factory, 'validatePluginManagerOptions', [$config, 'foo']);
    }

    /**
     * @return void
     */
    public function testValidatePluginManagerOptionsThrowsExceptionWhenServiceManagerKeyIsNotCorrect(): void
    {
        $config = new Config([
            'service_manager' => [],
            'config_key'      => 'bar',
            'class_method'    => 'bazMethod',
        ]);

        $this->expectException(ServiceNotCreatedException::class);
        $this->tester->invokeMethod($this->factory, 'validatePluginManagerOptions', [$config, 'foo']);
    }

    /**
     * @return void
     */
    public function testValidatePluginManagerOptionsThrowsExceptionWhenConfigKeyKeyNotExists(): void
    {
        $config = new Config([
            'service_manager' => 'foo',
            'class_method'    => 'bazMethod',
        ]);

        $this->expectException(ServiceNotCreatedException::class);
        $this->tester->invokeMethod($this->factory, 'validatePluginManagerOptions', [$config, 'foo']);
    }

    /**
     * @return void
     */
    public function testValidatePluginManagerOptionsThrowsExceptionWhenConfigKeyKeyIsNotCorrect(): void
    {
        $config = new Config([
            'service_manager' => 'foo',
            'config_key'      => true,
            'class_method'    => 'bazMethod',
        ]);

        $this->expectException(ServiceNotCreatedException::class);
        $this->tester->invokeMethod($this->factory, 'validatePluginManagerOptions', [$config, 'foo']);
    }

    /**
     * @return void
     */
    public function testValidatePluginManagerOptionsThrowsExceptionWhenClassMethodsKeyNotExists(): void
    {
        $config = new Config([
            'service_manager' => 'foo',
            'config_key'      => 'bar',
        ]);

        $this->expectException(ServiceNotCreatedException::class);
        $this->tester->invokeMethod($this->factory, 'validatePluginManagerOptions', [$config, 'foo']);
    }

    /**
     * @return void
     */
    public function testValidatePluginManagerOptionsThrowsExceptionWhenClassMethodsKeyIsNotCorrect(): void
    {
        $config = new Config([
            'service_manager' => 'foo',
            'config_key'      => 'bar',
            'class_method'    => 1.0,
        ]);

        $this->expectException(ServiceNotCreatedException::class);
        $this->tester->invokeMethod($this->factory, 'validatePluginManagerOptions', [$config, 'foo']);
    }

    /**
     * @depends testItCanValidatePluginManagerOptions
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanInjectServiceLoaderOptions(): void
    {
        $this->tester->assertObjectHasMethod('injectServiceLoaderOptions', $this->factory);
        $this->tester->assertObjectMethodIsProtected('injectServiceLoaderOptions', $this->factory);

        $options = [
            'foo' => [
                'service_manager' => 'foo',
                'config_key' => 'bar',
                'class_method' => 'bazMethod',
            ],
        ];

        $loader = $this->make(Loader::class);

        try {
            $this->tester->invokeMethod($this->factory, 'injectServiceLoaderOptions', [$options, $loader]);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
        verify(true)->true();

        try {
            $this->tester->invokeMethod($this->factory, 'injectServiceLoaderOptions', [new Config($options), $loader]);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
        verify(true)->true();
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testInjectServiceLoaderOptionsThrowsAnExceptionOnInvalidArgument(): void
    {
        $loader = $this->make(Loader::class);

        $this->expectException(ServiceNotCreatedException::class);
        $this->tester->invokeMethod($this->factory, 'injectServiceLoaderOptions', [true, $loader]);
    }

    /**
     * @return void
     */
    public function testItIsCallable(): void
    {
        $this->traitTestItIsCallable();

        $loader = ($this->factory)(
            $this->tester->getServiceManager(),
            Loader::class
        );

        verify($loader)->object();
        verify($loader)->isInstanceOf(Loader::class);
    }
}
