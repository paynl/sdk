<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use PayNL\Sdk\Common\FactoryInterface;
use PayNL\Sdk\Exception\ServiceNotFoundException;
use Psr\Container\ContainerInterface;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Filter
 */
class Factory implements FactoryInterface
{
    /**
     * @inheritDoc
     *
     * @return FilterInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): FilterInterface
    {
        if (false === class_exists($requestedName)) {
            throw new ServiceNotFoundException(
                sprintf(
                    'No service found with name "%s"',
                    $requestedName
                )
            );
        }

        return (new $requestedName())
            ->setValue($options['value'] ?? '')
        ;
    }
}
