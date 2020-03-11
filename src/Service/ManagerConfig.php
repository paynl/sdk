<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use PayNL\Sdk\Config\Loader as ConfigLoader;
use PayNL\Sdk\Service\LoaderFactory as ServiceLoaderFactory;
use PayNL\Sdk\Service\Loader as ServiceLoader;
use PayNL\Sdk\Service\Config as ServiceConfig;
use Psr\Container\ContainerInterface;

/**
 * Class ManagerConfig
 *
 * @package PayNL\Sdk\Service
 */
class ManagerConfig extends ServiceConfig
{
    /**
     * @var array
     */
    protected $config = [
        'config_paths' => [
            // sequence is important!
            // TODO: determine sequence by dependencies to other components?
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'AuthAdapter' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Response' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Hydrator' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Transformer' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Filter' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Validator' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Mapper' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
        ],
        'aliases' => [
            'serviceLoader' => ServiceLoader::class,
            'configLoader'  => ConfigLoader::class,
        ],
        'factories' => [
            ServiceLoader::class => ServiceLoaderFactory::class,
        ],
        'initializers' => [],
        'invokables'   => [],
        'mapping'      => [],
        'services'     => [],
    ];

    public function __construct(array $config = [])
    {
        $configPaths = $this->config['config_paths'];

        $this->config['factories'][ConfigLoader::class] = static function (ContainerInterface $container) use ($configPaths) {
            $appConfig = $container->get('ApplicationConfig');

            // get "custom" modules
            foreach ($appConfig['config_paths'] ?? [] as $configPath) {
                $configPaths[] = $configPath;
            }

            $appConfig->set('config_paths', $configPaths);

            $loader = new ConfigLoader($appConfig);
            $loader->load();

            return $loader;
        };

        $this->config['factories']['ServiceManager'] = static function (ContainerInterface $container) {
            return $container;
        };

        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function configureServiceManager(Manager $serviceManger): Manager
    {
        $this->get('services')->set(Manager::class, $serviceManger);

        // This is invoked as part of the bootstrapping process, and requires
        // the ability to override services.
        $serviceManger->setAllowOverride(true);
        parent::configureServiceManager($serviceManger);
        $serviceManger->setAllowOverride(false);

        return $serviceManger;
    }
}
