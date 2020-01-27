<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Psr\Container\ContainerInterface;

/**
 * Class InvokableFactory
 *
 * Factory for instantiating classes with no dependencies or which accept a single array.
 *
 * The InvokableFactory can be used for any class that:
 * - has no constructor arguments;
 * - accepts a single array of arguments via the constructor.
 *
 * Also used by the service manager for classes which are configured as "invokables" in t
 *  he config provider
 *
 * @package PayNL\Sdk\Factory
 */
final class InvokableFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        return (null === $options ? new $requestedName() : new $requestedName($options));
    }
}
