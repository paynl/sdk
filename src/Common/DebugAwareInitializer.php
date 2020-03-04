<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Psr\Container\ContainerInterface;

/**
 * Class DebugAwareInitializer
 *
 * Check for the given instance if it's aware of the debug mode and set
 *  the flag if that is the case
 *
 * @package PayNL\Sdk\Common
 */
class DebugAwareInitializer implements InitializerInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $instance): void
    {
        if (false === ($instance instanceof DebugAwareInterface)) {
            return;
        }

        $debug = $container->get('config')['debug'] ?? false;

        $instance->setDebug($debug);
    }
}
