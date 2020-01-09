<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;


use PayNL\Sdk\Common\ManagerFactory;
use PayNL\Sdk\Config\ProviderInterface;

class ConfigProvider implements ProviderInterface
{
    public function __invoke(): array
    {
        return [
            'service_manager' => $this->getDependencyConfig(),
            'service_loader_options' => [
                'mapperManager' => [
                    'service_manager' => 'mapperManager',
                    'config_key'    => 'mappers',
                    'class_method'  => 'getMappers',
                ],
            ],
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'aliases' => [
                'mapperManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    public function getMappers(): array
    {
        return [
            'aliases' => [
                'RequestModelMapper' => RequestModelMapper::class,
                'ModelHydratorMapper' => ModelHydratorMapper::class,
            ],
            'factories' => [
                RequestModelMapper::class => Factory::class,
                ModelHydratorMapper::class => Factory::class,
            ],
            'mapping' => $this->getMap(),
        ];
    }

    public function getMap(): array
    {
        return [
            'RequestModelMapper' => [
                'GetAllCurrencies' => 'Currencies'
            ],
            'ModelHydratorMapper' => [
                'Currencies' => 'Currencies',
            ],
        ];
    }
}
