<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\Common\{
    FactoryInterface,
    OptionsAwareInterface
};

/**
 * Class TransformerFactory
 *
 * @package PayNL\Sdk\Transformer
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
            $transformer->setOptions($options ?? []);
        }

        return $transformer;
    }
}
