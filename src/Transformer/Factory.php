<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Common\OptionsAwareInterface;
use Psr\Container\ContainerInterface;
use PayNL\Sdk\Common\FactoryInterface;

/**
 * Class TransformerFactory
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
        $transformer = new $requestedName($container);

        if ($transformer instanceof OptionsAwareInterface) {
            $transformer->setOptions($options ?: []);
        }

        return $transformer;
    }
}
