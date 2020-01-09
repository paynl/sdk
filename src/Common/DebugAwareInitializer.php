<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Psr\Container\ContainerInterface;

/**
 * Class DebugAwareInitializer
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
