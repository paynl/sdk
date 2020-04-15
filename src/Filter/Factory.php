<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use PayNL\Sdk\Common\FactoryInterface;
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
        return (new $requestedName())
            ->setValue($options['value'] ?? '')
        ;
    }
}
