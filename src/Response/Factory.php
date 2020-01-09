<?php

declare(strict_types=1);

namespace PayNL\Sdk\Response;

use PayNL\Sdk\Common\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Response
 */
class Factory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $responseFormat = $config['response']['format'] ?? ResponseInterface::FORMAT_OBJECTS;

        $response = new Response($container);
        $response->setFormat($responseFormat);

        if (ResponseInterface::FORMAT_OBJECTS === $responseFormat) {
            $response->setTransformer($container->get('transformerManager')->get('Response'));
        }

        return $response;
    }
}
