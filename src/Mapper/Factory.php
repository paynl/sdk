<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

use PayNL\Sdk\Common\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Mapper
 */
class Factory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        $mapConfig = $container->get('mapperManager')->getMapping();

        if (false === is_array($mapConfig) || true === empty($mapConfig)) {
            throw new \Exception('No map config');
        }

        if (false === array_key_exists($requestedName, $mapConfig)) {
            throw new \Exception('No map config for %s found, use %s');
        }

        return new $requestedName($mapConfig[$requestedName]);
    }
}
