<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use PayNL\Sdk\{Common\ManagerFactory,
    Config\ProviderInterface as ConfigProviderInterface,
    Validator\Qr\Decode,
    Validator\Qr\Encode
};

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Validator
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
                    'service_manager' => 'validatorManager',
                    'config_key'      => 'validators',
                    'class_method'    => 'getValidatorConfig',
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
                'validatorManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    public function getValidatorConfig(): array
    {
        return [
            'aliases' => [
                'InputType' => InputType::class,
                'ObjectInstance' => ObjectInstance::class,
                'RequiredMembers' => RequiredMembers::class,
                'Encode'        => Encode::class,
                'Decode'        => Decode::class
            ],
            'factories' => [
                InputType::class       => Factory::class,
                ObjectInstance::class  => Factory::class,
                RequiredMembers::class => Factory::class,
                Encode::class          => Factory::class,
                Decode::class          => Factory::class,
            ],
        ];
    }
}
