<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use PayNL\Sdk\{
    Service\Manager as ServiceManager,
    Service\Config as ServiceConfig,
    Config\Config,
    Exception,
    Config\Loader as ConfigLoader
};

/**
 * Class Loader
 *
 * @package PayNL\Sdk\Service
 */
class Loader
{
    /**
     * @var ServiceManager
     */
    protected $defaultServiceManager;

    /**
     * @var ServiceConfig|null
     */
    protected $defaultServiceConfig;

    /**
     * @var array
     */
    protected $serviceManagers = [];

    /**
     * Loader constructor.
     *
     * @param Manager $defaultServiceManager
     * @param ServiceConfig|null $configuration
     */
    public function __construct(ServiceManager $defaultServiceManager, ServiceConfig $configuration = null)
    {
        $this->defaultServiceManager = $defaultServiceManager;

        if (null !== $configuration) {
            $this->setDefaultServiceConfig($configuration);
        }
    }

    /**
     * @param ServiceConfig $configuration
     *
     * @return Loader
     */
    public function setDefaultServiceConfig(ServiceConfig $configuration): self
    {
        $this->defaultServiceConfig = $configuration;
        return $this;
    }

    /**
     * @param ServiceManager|string $serviceManager
     * @param string $key
     * @param string $mandatoryMethod
     *
     * @throws Exception\RuntimeException
     *
     * @return Loader
     */
    public function addServiceManager($serviceManager, string $key, string $mandatoryMethod): self
    {
        $smKey = '';
        if (true === is_string($serviceManager)) {
            $smKey = $serviceManager;
        } elseif ($serviceManager instanceof ServiceManager) {
            $smKey = spl_object_hash($serviceManager);
        }

        if ('' === $smKey) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Invalid service manager provided, expected instance of %s or string',
                    ServiceManager::class
                )
            );
        }

        $this->serviceManagers[$smKey] = [
            'service_manager' => $serviceManager,
            'config_key'      => $key,
            'class_method'    => $mandatoryMethod,
            'configuration'   => [],
        ];

        if ($key === 'service_manager' && $this->defaultServiceConfig) {
            $this->serviceManagers[$smKey]['configuration']['default_config'] = $this->defaultServiceConfig;
        }

        return $this;
    }

    /**
     * @return void
     */
    public function preLoad(): void
    {
        /** @var ConfigLoader $configLoader */
        $configLoader = $this->defaultServiceManager->get('configLoader');

        foreach ($this->serviceManagers as $key => $sm) {
            // search for config provider
            foreach ($configLoader->getConfigs() as $className => $provider) {
                if (false === method_exists($provider, $sm['class_method'])) {
                    continue;
                }

                $config = $provider->{$sm['class_method']}();

                if ($config instanceof ServiceConfig) {
                    $config = $this->serviceConfigToArray($config);
                }

                if ($config instanceof Config) {
                    $config = $config->toArray();
                }

                if (false === is_array($config)) {
                    // If we do not have an array by this point, nothing left to do.
                    continue 2;
                }

                $this->serviceManagers[$key]['configuration'][$className . '::' . $sm['class_method'] . '()'] = $config;
            }
        }
    }

    /**
     * @throws Exception\ServiceNotFoundException when the service manager can not be found
     *
     * @return void
     */
    public function load(): void
    {
        $config = $this->defaultServiceManager->get('configLoader')->getMergedConfig()->toArray();

        foreach ($this->serviceManagers as $key => $sm) {
            $smConfig = $this->mergeServiceConfig($key, $sm, $config);

            if (false === ($sm['service_manager'] instanceof ServiceManager)) {
                if (false === $this->defaultServiceManager->has($sm['service_manager'])) {
                    // No plugin manager registered by that name; nothing to configure.
                    continue;
                }

                /** @var ServiceManager $instance */
                $instance = $this->defaultServiceManager->get($sm['service_manager']);
                if (! $instance instanceof ServiceManager) {
                    throw new Exception\ServiceNotFoundException(
                        sprintf(
                            'Could not find service manager with name %s',
                            $sm['service_manager']
                        )
                    );
                }
                $sm['service_manager'] = $instance;
            }

            $serviceConfig = new ServiceConfig($smConfig->toArray());

            $allowOverride = $sm['service_manager']->hasAllowOverride();
            $sm['service_manager']->setAllowOverride(true);

            $serviceConfig->configureServiceManager($sm['service_manager']);

            $sm['service_manager']->setAllowOverride($allowOverride);
        }
    }

    /**
     * @param string $key
     * @param array $metadata
     * @param array $config
     *
     * @return Config
     */
    protected function mergeServiceConfig(string $key, array $metadata, array $config): Config
    {
        if (true === array_key_exists($metadata['config_key'], $config)
            && true === is_array($config[$metadata['config_key']])
            && false === empty($config[$metadata['config_key']])
        ) {
            $this->serviceManagers[$key]['configuration']['merged_config'] = $config[$metadata['config_key']];
        }

        $serviceConfig = new Config();//[];
        foreach ($this->serviceManagers[$key]['configuration'] as $configs) {
            if (true === is_array($configs)) {
                $configs = new Config($configs);
            }

            if (true === $configs->has('configuration_classes')) {
                foreach ($configs->get('configuration_classes') as $class) {
                    $configs->merge(new Config($this->serviceConfigToArray($class)));
                }
            }
            $serviceConfig->merge($configs);
        }

        return $serviceConfig;
    }

    /**
     * @param ServiceConfig|string $config
     *
     * @throws Exception\RuntimeException when resolved config class is not an instance of ServiceConfig
     *
     * @return array
     */
    protected function serviceConfigToArray($config): array
    {
        if (true === is_string($config) && true === class_exists($config)) {
            $class = $config;
            $config = new $class();
        }

        if (false === ($config instanceof ServiceConfig)) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Invalid service manager config class provided, expected "%s" but got "%s"',
                    ServiceConfig::class,
                    (is_object($config) ? get_class($config) : gettype($config))
                )
            );
        }

        /** @var ServiceConfig $config */
        return $config->toArray();
    }
}
