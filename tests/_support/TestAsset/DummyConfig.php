<?php

namespace Codeception\TestAsset;

use PayNL\Sdk\Config\Config;

class DummyConfig extends Config
{
    public function __invoke(): array
    {
        return [
            'foo',
            [
                'service_manager' => 'corge',
                'config_key'      => 'dummies',
                'class_method'    => 'grault',
            ],
            [
                'dummies' => [
                    'invokables' => [
                        'Dummy2' => Dummy::class,
                    ],
                ],
            ]
        ];
    }
}