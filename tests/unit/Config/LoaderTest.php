<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Config;

use Codeception\Test\Unit as UnitTest;
use Codeception\TestAsset\SampleConfigProvider;
use PayNL\Sdk\Config\Config;
use PayNL\Sdk\Config\Loader;
use PayNL\Sdk\Exception\ConfigNotFoundException;
use PayNL\Sdk\Exception\InvalidArgumentException;
use UnitTester,
    Mockery
;

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

    /**
     * @var array
     */
    protected $testConfig = [];

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->testConfig = [
            'foo' => 'bar',
            'baz' => [
                'qux'
            ],
            'config_paths' => [],
        ];

        $this->loader = new Loader();
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify(new Loader())->isInstanceOf(Loader::class);
    }

    /**
     * @return void
     */
    public function testItCanGetPaths(): void
    {
        $this->tester->assertObjectHasMethod('getPaths', $this->loader);
        $this->tester->assertObjectMethodIsProtected('getPaths', $this->loader);

        $paths = $this->tester->invokeMethod($this->loader, 'getPaths');
        verify($paths)->array();
        verify($paths)->isEmpty();
    }

    /**
     * @depends testItCanGetPaths
     *
     * @return void
     */
    public function testItCanAddAPath(): void
    {
        $sampleConfigProviderPath = __DIR__ . '/../../_support/TestAsset/SampleConfigProvider.php';
        verify($this->loader->addPath($sampleConfigProviderPath))->isInstanceOf(Loader::class);

        $paths = $this->tester->invokeMethod($this->loader, 'getPaths');
        verify($paths)->count(1);
        verify($paths)->contains($sampleConfigProviderPath);
    }

    /**
     * @depends testItCanGetPaths
     *
     * @return void
     */
    public function testItCanAddPathsWithASingleString(): void
    {
        $sampleConfigProviderPath = __DIR__ . '/../../_support/TestAsset/SampleConfigProvider.php';
        verify($this->loader->addPaths($sampleConfigProviderPath))->isInstanceOf(Loader::class);

        $paths = $this->tester->invokeMethod($this->loader, 'getPaths');
        verify($paths)->count(1);
        verify($paths)->contains($sampleConfigProviderPath);
    }

    /**
     * @depends testItCanGetPaths
     *
     * @return void
     */
    public function testItCanAddPathsWithAnIterable(): void
    {
        $sampleConfigProviderPath = __DIR__ . '/../../_support/TestAsset/SampleConfigProvider.php';
        verify($this->loader->addPaths([$sampleConfigProviderPath]))->isInstanceOf(Loader::class);

        $paths = $this->tester->invokeMethod($this->loader, 'getPaths');
        verify($paths)->count(1);
        verify($paths)->contains($sampleConfigProviderPath);
    }

    /**
     * @return void
     */
    public function testAddPathsThrowsExceptionWhenParameterIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->loader->addPaths(0);
    }

    /**
     * @depends testItCanConstruct
     *
     * @return void
     */
    public function testItCanConstructWithArrayConfig(): void
    {
        $loader = new Loader($this->testConfig);
        verify($loader)->isInstanceOf(Loader::class);
    }

    /**
     * @depends testItCanConstruct
     *
     * @return void
     */
    public function testItCanConstructWithConfigObject(): void
    {
        $configMock = Mockery::spy(Config::class, [$this->testConfig]);
        $loader = new Loader($configMock);
        verify($loader)->isInstanceOf(Loader::class);
    }

    /**
     * @return void
     */
    public function testConstructThrowsExceptionWhenConfigIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Loader(0);
    }

    /**
     * @return void
     */
    public function testItCanGetConfigs(): void
    {
        $this->tester->assertObjectHasMethod('getConfigs', $this->loader);
        $configs = $this->loader->getConfigs();
        verify($configs)->array();
        verify($configs)->isEmpty();
    }

    /**
     * @depends testItCanGetConfigs
     *
     * @return void
     */
    public function testItCanAddConfig(): void
    {
        $this->tester->assertObjectHasMethod('addConfig', $this->loader);
        $this->tester->assertObjectMethodIsProtected('addConfig', $this->loader);

        $providerMock = Mockery::spy(SampleConfigProvider::class);
        verify($this->tester->invokeMethod($this->loader, 'addConfig', ['foo', $providerMock]))
            ->isInstanceOf(Loader::class)
        ;

        $configs = $this->loader->getConfigs();
        verify($configs)->count(1);
    }

    /**
     * @depends testItCanAddConfig
     * @depends testItCanGetConfigs
     *
     * @return void
     */
    public function testItCanAddConfigByPath(): void
    {
        $this->tester->assertObjectHasMethod('addConfigByPath', $this->loader);

        $sampleConfigProviderPath = __DIR__ . '/../../_support/TestAsset/SampleConfigProvider.php';

        verify($this->loader->addConfigByPath($sampleConfigProviderPath))->isInstanceOf(Loader::class);
        $configs = $this->loader->getConfigs();
        verify($configs)->count(1);
    }

    /**
     * @return void
     */
    public function testAddConfigPyPathThrowsExceptionWhenNonExistingFileGiven(): void
    {
        $this->expectException(ConfigNotFoundException::class);
        $failingConfigProviderPath = __DIR__ . '/../../_support/TestAsset/NonExistingConfigProvider.php';
        $this->loader->addConfigByPath($failingConfigProviderPath);
    }

    /**
     * @return void
     */
    public function testAddConfigByPathThrowsExceptionWhenInvalidClassName(): void
    {
        $this->expectException(ConfigNotFoundException::class);
        $failingConfigProviderPath = __DIR__ . '/../../_support/TestAsset/FailingConfigProvider.php';
        $this->loader->addConfigByPath($failingConfigProviderPath);
    }

    /**
     * @return void
     */
    public function testItCanGetMergedConfig(): void
    {
        $this->tester->assertObjectHasMethod('getMergedConfig', $this->loader);
        $mergedConfig = $this->loader->getMergedConfig();
        verify($mergedConfig)->object();
        verify($mergedConfig)->isInstanceOf(Config::class);
        verify($mergedConfig)->isEmpty();
    }

    /**
     * @depends testItCanAddConfigByPath
     * @depends testItCanAddPathsWithASingleString
     * @depends testItCanGetMergedConfig
     *
     * @return void
     */
    public function testItCanLoad(): void
    {
        $sampleConfigProviderPath = __DIR__ . '/../../_support/TestAsset/SampleConfigProvider.php';
        $this->loader->addConfigByPath($sampleConfigProviderPath);

        verify($this->loader->load())->isInstanceOf(Loader::class);

        $mergedConfig = $this->loader->getMergedConfig();
        verify($mergedConfig)->notEmpty();
    }
}
