<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Common\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Hydrator
 */
class Factory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        return new $requestedName($container->get('hydratorManager'), $container->get('modelManager'));
    }
}
