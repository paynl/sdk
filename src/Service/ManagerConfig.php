<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;


use PayNL\Sdk\Config\Loader as ConfigLoader;
use PayNL\Sdk\Service\LoaderFactory as ServiceLoaderFactory;
use PayNL\Sdk\Service\Loader as ServiceLoader;
use Psr\Container\ContainerInterface;

class ManagerConfig extends Config
{
    protected $config = [
        'aliases' => [
            'serviceLoader' => ServiceLoader::class,
            'configLoader'  => ConfigLoader::class,
        ],
        'factories' => [
            ServiceLoader::class => ServiceLoaderFactory::class,
        ],
    ];

    public function __construct(array $config = [])
    {
        $this->config['factories'][ConfigLoader::class] = static function (ContainerInterface $container) {
            $appConfig = $container->get('ApplicationConfig');
            // TODO: move to config?
            $appConfig['config_paths'] = [
                // sequence is important!
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'AuthAdapter' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Response' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Hydrator' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Transformer' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
//                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Filter' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
//                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Validator' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Mapper' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
                dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
            ];



            $loader = new ConfigLoader($appConfig);
            $loader->load();

            return $loader;
        };

        $this->config['factories']['ServiceManager'] = static function (ContainerInterface $container) {
            return $container;
        };

        parent::__construct($config);
    }

    public function configureServiceManager(Manager $serviceManger): Manager
    {
        $this->config['services'][Manager::class] = $serviceManger;

        $serviceManger->setAllowOverride(true);
        parent::configureServiceManager($serviceManger);
        $serviceManger->setAllowOverride(false);

        return $serviceManger;
    }
}
