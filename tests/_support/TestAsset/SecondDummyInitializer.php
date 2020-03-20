<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Common\InitializerInterface;
use Psr\Container\ContainerInterface;

/**
 * Class SecondDummyInitializer
 *
 * @package Codeception\TestAsset
 */
class SecondDummyInitializer implements InitializerInterface
{
    public function __invoke(ContainerInterface $container, $instance): void
    {

    }
}
