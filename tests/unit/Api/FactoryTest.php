<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Api;

use Codeception\{
    Test\Unit as UnitTest,
    Lib\FactoryTestTrait
};
use PayNL\Sdk\{
    Api\Factory,
    Api\Api,
    Api\Service as ApiService,
    Config\Config,
    Service\Manager as ServiceManager,
    Exception\ServiceNotFoundException,
    Exception\InvalidArgumentException
};
use Psr\Container\ContainerInterface;
use UnitTester;

/**
 * Class FactoryTest
 *
 * @package Tests\PayNL\Sdk\unit\Api
 */
class FactoryTest extends UnitTest
{
    use FactoryTestTrait;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var ServiceManager
     */
    protected $serviceManagerMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->serviceManagerMock = $this->tester->getServiceManager();
        $this->factory = new Factory();
    }

    /**
     * @return void
     */
    public function testItCanCreateApi(): void
    {
        $api = ($this->factory)($this->serviceManagerMock, Api::class);
        verify($api)->isInstanceOf(Api::class);
    }

    /**
     * @return void
     */
    public function testItCanCreateApiService(): void
    {
        $service = ($this->factory)($this->serviceManagerMock, ApiService::class);
        verify($service)->isInstanceOf(ApiService::class);
    }

    /**
     * @return void
     */
    public function testItThrowAnExceptionWhenRequestedNameIsNotSupported(): void
    {
        $this->expectException(ServiceNotFoundException::class);
        ($this->factory)($this->serviceManagerMock, 'UnsupportedClassName');
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenInvalidApiUrlHasNoScheme(): void
    {
        $container = new class implements ContainerInterface
        {
            public function get($id)
            {
                if ('config' === $id) {
                    return new Config([
                        'api' => [
                            'url' => 'foo.bar.baz',
                        ],
                    ]);
                }
            }

            public function has($id)
            {
                return 'config' === $id;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        ($this->factory)($container, Api::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenInvalidApiUrlHasHttpScheme(): void
    {
        $container = new class implements ContainerInterface
        {
            public function get($id)
            {
                if ('config' === $id) {
                    return new Config([
                        'api' => [
                            'url' => 'http://foo.bar.baz/',
                        ],
                    ]);
                }
            }

            public function has($id)
            {
                return 'config' === $id;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        ($this->factory)($container, Api::class);
    }
}
