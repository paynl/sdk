<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Service\AbstractPluginManager;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Transformer
 */
class Manager extends AbstractPluginManager
{
    protected $instanceOf = TransformerInterface::class;

    public function getByRequest($requestName, array $options = []): TransformerInterface
    {
        $transformerConfig = $this->getMapping('from_request')[$requestName] ?? null;

        if (null === $transformerConfig) {
            throw new \Exception('No transformer mapped for request!');
        }

        if (false === array_key_exists('transformer', $transformerConfig)) {
            throw new \Exception('No transformer set for request');
        }

        return $this->get($transformerConfig['transformer'], ArrayUtils::merge($options, $transformerConfig['options']));
    }
}
