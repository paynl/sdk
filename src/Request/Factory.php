<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\Sdk\Common\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Factory
 */
class Factory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $requestFormat = $config['request']['format'] ?? RequestInterface::FORMAT_OBJECTS;

        /** @var AbstractRequest $request */
        $request = new $requestedName($options ?: []);
        $request->setFormat($requestFormat);

        return $request;
    }
}
