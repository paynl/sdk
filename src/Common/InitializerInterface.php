<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Psr\Container\ContainerInterface;

/**
 * Interface InitializerInterface
 *
 * @package PayNL\Sdk\Common
 */
interface InitializerInterface
{
    /**
     * @param ContainerInterface $container
     * @param object $instance
     *
     * @return void
     */
    public function __invoke(ContainerInterface $container, $instance): void;
}
