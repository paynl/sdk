<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use PayNL\Sdk\{
    Application,
    Common\DebugAwareInitializer,
    Common\FactoryInterface,
    Service\Manager as ServiceManager,
    Service\Loader as ServiceLoader,
    Service\Config as ServiceConfig,
    Config\Config,
    Config\Factory as ConfigFactory,
    Exception
};
use Psr\Container\ContainerInterface;

/**
 * Class LoaderFactory
 *
 * @package PayNL\Sdk\Service
 */
class LoaderFactory implements FactoryInterface
{
    /*
     * Error message constant definitions
     */
    private const MISSING_KEY_ERROR = 'Invalid service loader options detected, %s config must contain %s key.';
    private const VALUE_TYPE_ERROR  = 'Invalid service loader options detected, %s must be a string, %s given.';

    /**
     * @var array
     */
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

    /**
     * @inheritDoc
     *
     * @return ServiceLoader
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): ServiceLoader
    {
        /**
         * @var Config $configuration
         */
        $configuration = $container->get('configLoader')->getMergedConfig();

//        $serviceLoader = $container->has('serviceLoaderInterface') ? $container->get('serviceLoaderInterface') : new ServiceLoader($container);

        /** @var ServiceManager $serviceManager */
        $serviceManager = $container;

        $serviceLoader = new ServiceLoader($serviceManager);

        $serviceLoader->setDefaultServiceConfig(new ServiceConfig($this->defaultServiceConfig));

        $serviceLoader->addServiceManager($serviceManager, 'service_manager', 'getServiceConfig');

        if (true === $configuration->has('service_loader_options')) {
            $this->injectServiceLoaderOptions($configuration->get('service_loader_options'), $serviceLoader);
        }

        $serviceLoader->preLoad();

        return $serviceLoader;
    }

    /**
     * @param mixed $options
     * @param ServiceLoader $serviceLoader
     *
     * @throws Exception\ServiceNotCreatedException
     *
     * @return void
     */
    protected function injectServiceLoaderOptions($options, ServiceLoader $serviceLoader): void
    {
        if (true === is_array($options)) {
            $options = new Config($options);
        } elseif (false === ($options instanceof Config)) {
            throw new Exception\ServiceNotCreatedException(
                sprintf(
                    'The given options to %s must be an array or an instance of %s, %s given',
                    __METHOD__,
                    Config::class,
                    (is_object($options) === true ? get_class($options) : gettype($options))
                )
            );
        }

        /**
         * @var Config $newServiceManager
         */
        foreach ($options as $key => $newServiceManager) {
            $this->validatePluginManagerOptions($newServiceManager, $key);

            $serviceLoader->addServiceManager(
                $newServiceManager->get('service_manager'),
                $newServiceManager->get('config_key'),
                $newServiceManager->get('class_method')
            );
        }
    }

    /**
     * @param Config $options
     * @param string $name
     *
     * @throws Exception\ServiceNotCreatedException
     *
     * @return void
     */
    private function validatePluginManagerOptions(Config $options, $name): void
    {
        $mandatoryManagerConfigKeys = [
            'service_manager',
            'config_key',
            'class_method',
        ];

        /** @var Config $options */
        foreach ($mandatoryManagerConfigKeys as $managerConfigKey) {
            if (false === $options->has($managerConfigKey)) {
                throw new Exception\ServiceNotCreatedException(
                    sprintf(
                        self::MISSING_KEY_ERROR,
                        $name,
                        $managerConfigKey
                    )
                );
            }

            if (false === is_string($options->get($managerConfigKey))) {
                throw new Exception\ServiceNotCreatedException(
                    sprintf(
                        self::VALUE_TYPE_ERROR,
                        $managerConfigKey,
                        gettype($options->get($managerConfigKey))
                    )
                );
            }
        }
    }
}
