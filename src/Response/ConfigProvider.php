<?php

declare(strict_types=1);

namespace PayNL\Sdk\Response;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Response
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
        ];
    }

    /**
     * @inheritDoc
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases' => [
                'Response' => Response::class,
                'response' => Response::class,
            ],
            'factories' => [
                Response::class => Factory::class,
            ],
        ];
    }
}
