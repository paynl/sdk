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
        if (null === $options) {
            $options = [];
        }

        $config = $container->get('config');
        $options['format'] = $config['request']['format'] ?? RequestInterface::FORMAT_OBJECTS;

        /** @var AbstractRequest $request */
        $request = new $requestedName(
            $container->get('validatorManager')->get('RequiredMembers'),
            $options
        );

        return $request;
    }
}
