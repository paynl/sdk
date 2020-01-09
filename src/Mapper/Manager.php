<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

use PayNL\Sdk\Exception\ServiceNotFoundException;
use PayNL\Sdk\Service\AbstractPluginManager;
use Zend\Stdlib\ArrayUtils;
use PayNL\Sdk\Service\Manager as ServiceManager;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Mapper
 */
class Manager extends AbstractPluginManager
{
    /**
     * @var string
     */
    protected $instanceOf = MapperInterface::class;

    /**
     * @var array
     */
    protected $mapping = [];

    /**
     * @inheritDoc
     */
    public function configure(array $config): ServiceManager
    {
        parent::configure($config);

        if (true === array_key_exists('mapping', $config) && false === empty($config['mapping'])) {
            $mappingConfig = $config['mapping'];


            foreach ($mappingConfig as $mapper => $map) {
                // check the mapping keys, see if the class exists
                $mapperAlias = $mapper;
                $mapper = $this->resolvedAliases[$mapperAlias] ?? $mapperAlias;

                if (false === class_exists($mapper)) {
                    throw new \Exception('No mapper');
                }

                $mappingConfig[$mapper] = $map;
                unset($mappingConfig[$mapperAlias]);

                // determine the necessary managers
                preg_match_all('/((?:^|[A-Z])[a-z]+)/', str_replace([__NAMESPACE__, 'Mapper'], '', $mapper), $matches);
                if (2 < count($matches[1])) {
                    throw new \Exception(
                        'invalid name'
                    );
                }

                $sourceManagerName = lcfirst(current($matches[1]));
                $targetManagerName = lcfirst(end($matches[1]));

                $sourceManager = $this->creationContext->get("{$sourceManagerName}Manager");
                $targetManager = $this->creationContext->get("{$targetManagerName}Manager");

                // check the map
                foreach ($map as $source => $target) {
                    $source = $sourceManager->resolvedAliases[$source] ?? $source;
                    if (false === class_exists($source)) {
                        throw new ServiceNotFoundException(
                            'Source does not exist'
                        );
                    }

                    $target = $targetManager->resolvedAliases[$target] ?? $target;
                    if (false === class_exists($target)) {
                        throw new ServiceNotFoundException(
                            sprintf(
                                'Service with name "%s" not found in %s',
                                $target,
                                $targetManagerName
                            )
                        );
                    }

                    $map[$source] = $target;
                }

                $mappingConfig[$mapper] = $map;
            }

            $this->mapping = ArrayUtils::merge($mappingConfig, $this->mapping);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function validateOverrides(array $config): void
    {
        if (isset($config['mapping'])) {
            $this->validateOverrideSet(array_keys($config['mapping']), 'mapping');
        }
        parent::validateOverrides($config);
    }

    public function getMapping(): array
    {
        return $this->mapping;
    }
}
