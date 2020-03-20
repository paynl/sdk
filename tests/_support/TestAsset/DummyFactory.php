<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Common\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class DummyFactory
 *
 * @package Codeception\TestAsset
 */
class DummyFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        return new $requestedName();
    }
}
