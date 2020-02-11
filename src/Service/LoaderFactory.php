<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use PayNL\Sdk\Application;
use PayNL\Sdk\Common\DebugAwareInitializer;
use PayNL\Sdk\Service\Manager as ServiceManager;
use PayNL\Sdk\Service\Loader as ServiceLoader;
use PayNL\Sdk\Service\Config as ServiceConfig;
use PayNL\Sdk\Config\Config;
use PayNL\Sdk\Exception;
use Psr\Container\ContainerInterface;
use PayNL\Sdk\Common\FactoryInterface;
use PayNL\Sdk\Config\Factory as ConfigFactory;

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
                    (is_object($options) ? get_class($options) : gettype($options))
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


//        if (false === $options->has('service_manager')) {
//            throw new Exception\ServiceNotCreatedException(
//                sprintf(
//                    self::MISSING_KEY_ERROR,
//                    $name,
//                    'service_manager'
//                )
//            );
//        }
//
//        if (false === is_string($options->get('service_manager'))) {
//            throw new Exception\ServiceNotCreatedException(
//                sprintf(
//                    self::VALUE_TYPE_ERROR,
//                    'service_manager',
//                    gettype($options->get('service_manager'))
//                )
//            );
//        }
//
//        if (false === $options->has('config_key')) {
//            throw new Exception\ServiceNotCreatedException(
//                sprintf(
//                    self::MISSING_KEY_ERROR,
//                    $name,
//                    'config_key'
//                )
//            );
//        }
//
//        if (false === is_string($options->get('config_key'))) {
//            throw new Exception\ServiceNotCreatedException(
//                sprintf(
//                    self::VALUE_TYPE_ERROR,
//                    'service_manager',
//                    gettype($options->get('config_key'))
//                )
//            );
//        }
//
//        if (false === $options->has('class_method')) {
//            throw new Exception\ServiceNotCreatedException(
//                sprintf(
//                    self::MISSING_KEY_ERROR,
//                    $name,
//                    'class_method'
//                )
//            );
//        }
//
//        if (false === is_string($options->get('class_method'))) {
//            throw new Exception\ServiceNotCreatedException(
//                sprintf(
//                    self::VALUE_TYPE_ERROR,
//                    'service_manager',
//                    gettype($options->get('class_method'))
//                )
//            );
//        }
    }
}
