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
        // TODO move to loader factory
        $this->config['factories'][ConfigLoader::class] = static function (ContainerInterface $container) {
            $appConfig = $container->get('ApplicationConfig');

            // sequence is important!
            // TODO: determine sequence by dependencies to other components?
            $components = [
                'AuthAdapter', 'Model', 'Request', 'Response', 'Hydrator', 'Transformer', 'Filter', 'Validator', 'Mapper', 'Api'
            ];

            $configPaths = [];
            foreach ($components as $component) {
                $configPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR . 'ConfigProvider.php';
                if (false !== realpath($configPath)) {
                    $configPaths[] = $configPath;
                }
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
