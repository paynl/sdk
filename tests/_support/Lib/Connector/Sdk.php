<?php

namespace Codeception\Lib\Connector;

use PayNL\Sdk\Service\AbstractPluginManager;
use PHPUnit\Framework\AssertionFailedError;
use PayNL\Sdk\Application\Application;
use PayNL\Sdk\Service\Manager as ServiceManager;
use Psr\Container\ContainerInterface;
use Mockery;

class Sdk
{
    /**
     * @var Application
     */
    protected $application;

    protected $applicationConfig;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function setApplicationConfig($config): void
    {
        $this->applicationConfig = $config;
        $this->initApplication();
    }

    public function initApplication(): Application
    {
        $this->application = Application::init($this->applicationConfig);
        $this->serviceManager = $this->application->getServiceManager();

        return $this->application;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function getServiceManager(): ServiceManager
    {
        return $this->serviceManager;
    }

    /**
     * @param string $name
     * @param ContainerInterface|null $container
     * @param array|null $options
     *
     * @return object
     */
    public function grabServiceFromContainer(string $name, ContainerInterface $container = null, array $options = null)
    {
        if (null === $container) {
            $container = $this->getServiceManager();
        }

        if (false === $container->has($name)) {
            throw new AssertionFailedError(
                sprintf(
                    'Service with name "%s" not found within the container',
                    $name
                )
            );
        }

        if ($container instanceof AbstractPluginManager) {
            return $container->get($name, $options);
        }

        return $container->get($name);
    }

    /**
     * @param string $serviceName
     * @param ContainerInterface|null $container
     * @param array|null $options
     *
     * @return Mockery\MockInterface
     */
    public function grabMockedServiceFromContainer(string $serviceName, ContainerInterface $container = null, array $options = null): Mockery\MockInterface
    {
        if (null === $container) {
            $container = $this->getServiceManager();
        }

        $service = $this->grabServiceFromContainer($serviceName, $container, $options);

        if ($service instanceof ContainerInterface) {
            $mockedService = $this->generateMockContainer($service);
        } else {
            $mockedService = Mockery::spy(get_class($service));
        }

        return $mockedService;
    }

    /**
     * @param ContainerInterface $serviceManger
     *
     * @return Mockery\MockInterface
     */
    protected function generateMockContainer(ContainerInterface $serviceManger): Mockery\MockInterface
    {
        $context = $this;

        $mockedService = Mockery::mock(get_class($serviceManger));

        $mockedService->shouldReceive('has')
            ->withArgs(static function ($name) {
                return true === is_string($name);
            })
            ->andReturnUsing(static function ($name) use ($mockedService) {
                return $mockedService->mockery_callSubjectMethod('has', [$name]);
            })
        ;

        $mockedService->shouldReceive('get')
            ->withArgs(static function ($name, ...$args) use ($serviceManger) {
                $stringMatcher = Mockery::type('string');
                if (false === ($serviceManger instanceof AbstractPluginManager)) {
                    return $stringMatcher->match($name);
                }

                $options = array_shift($args);
                return (true === $stringMatcher->match($name)
                    && (null === $options || true === Mockery::type('array')->match($options))
                );
            })
            ->andReturnUsing(static function ($name, ...$args) use ($context, $serviceManger) {
                return $context->grabMockedServiceFromContainer($name, $serviceManger, array_shift($args));
            })
        ;

        return $mockedService;
    }
}
