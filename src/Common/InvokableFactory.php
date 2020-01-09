<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Psr\Container\ContainerInterface;

/**
 * Class InvokableFactory
 *
 * @package PayNL\Sdk\Factory
 */
final class InvokableFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        return (null === $options ? new $requestedName() : new $requestedName($options));
    }
}
