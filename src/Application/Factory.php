<?php

declare(strict_types=1);

namespace PayNL\Sdk\Application;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\Common\FactoryInterface;

/**
 * Class ApplicationFactory
 *
 * @package PayNL\Sdk\Factory
 */
class Factory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        // init "default" response
        $response = $container->get('Response');
        $response->setStatusCode(500);

        return new Application(
            $container,
            $response
        );
    }
}
