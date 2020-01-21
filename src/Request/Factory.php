<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\Sdk\Common\FactoryInterface;
use PayNL\Sdk\Filter\FilterInterface;
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

        if (true === array_key_exists('filters', $options)) {
            // we've got filer, initiate them and "override" the filter in the set
            foreach ($options['filters'] as $filterName => $value) {
                /** @var FilterInterface $filter */
                $filter = $container->get('filterManager')->get($filterName, ['value' => $value]);

                unset($options['filters'][$filterName]);
                $options['filters'][$filter->getName()] = $filter;
            }
        }

        /** @var AbstractRequest $request */
        $request = new $requestedName($options);

        return $request;
    }
}
