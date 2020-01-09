<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;


use PayNL\Sdk\Application;
use PayNL\Sdk\Common\DebugAwareInitializer;
use PayNL\Sdk\Common\ManagerMappingInitializer;
use PayNL\Sdk\Service\Manager as ServiceManager;
use PayNL\Sdk\Service\Loader as ServiceLoader;
use PayNL\Sdk\Exception;
use Psr\Container\ContainerInterface;
use PayNL\Sdk\Common\FactoryInterface;
use PayNL\Sdk\Config\Factory as ConfigFactory;

class LoaderFactory implements FactoryInterface
{
    protected $defaultServiceConfig = [
        'aliases' => [
            'Application' => Application\Application::class,
            'application' => Application\Application::class,
            'serviceManager' => 'ServiceManager',
            'Config' => 'config',
            'configuration' => 'config',
        ],
        'invokables' => [],
        'factories' => [
            Application\Application::class => Application\Factory::class,
            'config' => ConfigFactory::class,
        ],
        'initializers' => [
            DebugAwareInitializer::class,
        ],
    ];

    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        $configuration = $container->get('configLoader')->getMergedConfig();

        /** @var ServiceManager $container */
        $serviceLoader = new ServiceLoader($container);

        $serviceLoader->setDefaultServiceConfig($this->defaultServiceConfig);

        $serviceLoader->addServiceManager($container, 'service_manager', 'getServiceConfig');

        if (true === isset($configuration['service_loader_options'])) {
            $this->injectServiceLoaderOptions($configuration['service_loader_options'], $serviceLoader);
        }

        $serviceLoader->preLoad();

        return $serviceLoader;
    }

    /**
     * @param array $options
     * @param ServiceLoader $serviceLoader
     *
     * @throws Exception\ServiceNotCreatedException
     *
     * @return void
     */
    protected function injectServiceLoaderOptions($options, ServiceLoader $serviceLoader): void
    {
        if (false === is_array($options)) {
            throw new Exception\ServiceNotCreatedException(
                sprintf(
                    'The given options to %s must be an array, %s given',
                    __METHOD__,
                    (is_object($options) ? get_class($options) : gettype($options))
                )
            );
        }

        foreach ($options as $key => $serviceManager) {
            // TODO: validate

            $serviceLoader->addServiceManager(
                $serviceManager['service_manager'],
                $serviceManager['config_key'],
                $serviceManager['class_method']
            );
        }
    }
}
