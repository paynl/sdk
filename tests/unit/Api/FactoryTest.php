<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Api;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Api\Factory,
    Api\Api,
    Api\Service as ApiService,
    Common\FactoryInterface,
    Service\Manager as ServiceManager,
    Exception\ServiceNotFoundException
};
use UnitTester;

/**
 * Class FactoryTest
 *
 * @package Tests\PayNL\Sdk\unit\Api
 */
class FactoryTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Factory
     */
    protected $factory;

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
    public function testItIsAFactory(): void
    {
        verify($this->factory)->isInstanceOf(FactoryInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsCallable(): void
    {
        verify(method_exists($this->factory, '__invoke'))->true();
        verify($this->factory)->callable();
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
}
