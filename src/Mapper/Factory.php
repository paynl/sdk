<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

use PayNL\Sdk\{
    Common\FactoryInterface,
    Exception\ServiceNotCreatedException
};
use Psr\Container\ContainerInterface;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Mapper
 */
class Factory implements FactoryInterface
{
    /**
     * @inheritDoc
     *
     * @return AbstractMapper
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): AbstractMapper
    {
        $mapConfig = $container->get('mapperManager')->getMapping();

        if (false === is_array($mapConfig) || true === empty($mapConfig)) {
            throw new ServiceNotCreatedException(
                'No map config is set'
            );
        }

        if (false === array_key_exists($requestedName, $mapConfig)) {
            throw new ServiceNotCreatedException(
                sprintf(
                    'No entry found within map config for "%s"',
                    $requestedName
                )
            );
        }

        return new $requestedName($mapConfig[$requestedName]);
    }
}