<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Service\Config as ServiceConfig;

class DummyConfig extends ServiceConfig
{
    /**
     * @var array
     */
    protected $config = [
        'aliases'      => [],
        'factories'    => [],
        'initializers' => [],
        'invokables'   => [
            'DummyInvokable' => InvokableObject::class,
        ],
        'mapping'      => [],
        'services'     => [],
    ];
}
