<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Common\ManagerFactory,
    Config\ProviderInterface as ConfigProviderInterface
};

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Transformer
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [
            'service_manager' => $this->getDependencyConfig(),
            'service_loader_options' => [
                Manager::class => [
                    'service_manager' => 'transformerManager',
                    'config_key'      => 'transformers',
                    'class_method'    => 'getTransformerConfig',
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases' => [
                'transformerManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getTransformerConfig(): array
    {
        return [
            'aliases' => [
                'response'   => Response::class,
                'Response'   => Response::class,
            ],
            'factories' => [
                Response::class   => Factory::class,
            ],
        ];
    }
}
