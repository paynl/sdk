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
     *
     * @return RequestInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): RequestInterface
    {
        if (null === $options) {
            $options = [];
        }

        $config = $container->get('config');
        $options['format'] = $config->get('request')->get('format') ?? RequestInterface::FORMAT_OBJECTS;

        if (true === array_key_exists('filters', $options)) {
            // we've got filer, initiate them and "override" the filter in the set
            foreach ($options['filters'] as $filterName => $value) {
                /** @var FilterInterface $filter */
                $filter = $container->get('filterManager')->get($filterName, ['value' => $value]);

                unset($options['filters'][$filterName]);
                $options['filters'][$filter->getName()] = $filter;
            }
        }

        $uri            = $options['uri'] ?? '';
        $method         = $options['method'] ?? '';
        $requiredParams = $options['requiredParams'] ?? [];
        unset($options['uri'], $options['method'], $options['requiredParams']);

        /** @var RequestInterface $request */
        $request = new $requestedName(
            $uri,
            $method,
            $requiredParams,
            $options
        );

        return $request;
    }
}
