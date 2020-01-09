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

        // need model, need hydrator

        $model = $container->get('modelManager')->get('currencies');
        $hydrator = $container->get('hydratorManager')->get('currencies');

        $transformer = new $requestedName($model, $hydrator);

        if ($transformer instanceof OptionsAwareInterface) {
            $transformer->setOptions($options ?: []);
        }

        return $transformer;
    }
}
