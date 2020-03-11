<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Common\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class SampleFactory
 *
 * @package Codeception\TestAsset
 */
class SampleFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        return new InvokableObject($options);
    }
}
