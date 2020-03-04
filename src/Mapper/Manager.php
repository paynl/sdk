<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

use PayNL\Sdk\{
    Config\Config,
    Service\AbstractPluginManager,
    Service\Manager as ServiceManager,
    Exception\ServiceNotFoundException,
    Exception\ServiceNotCreatedException
};

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Mapper
 */
class Manager extends AbstractPluginManager
{
    /**
     * @var string
     *
     * @see AbstractPluginManager::$instanceOf
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

        $currentMapping = new Config($this->mapping);
        $mappingConfig = [];

        if (false === empty($config['mapping'])) {
            $mappingConfig = $config['mapping'];


            foreach ($mappingConfig as $mapper => $map) {
                // check the mapping keys, see if the class exists
                $mapperAlias = $mapper;
                $mapper = $this->resolvedAliases[$mapperAlias] ?? $mapperAlias;

                if (false === class_exists($mapper)) {
                    throw new ServiceNotCreatedException(
                        sprintf(
                            'Can not initiate mapper object, class "%s" does not exist',
                            $mapper
                        )
                    );
                }

                $mappingConfig[$mapper] = $map;
                unset($mappingConfig[$mapperAlias]);

                // determine the necessary managers
                preg_match_all('/((?:^|[A-Z])[a-z]+)/', str_replace([__NAMESPACE__, 'Mapper'], '', $mapper), $matches);
                if (2 < count($matches[1])) {
                    throw new ServiceNotFoundException(
                        'invalid name'
                    );
                }

                $sourceManagerName = lcfirst(current($matches[1]));
                $targetManagerName = lcfirst(end($matches[1]));

                $sourceManager = $this->creationContext->get("{$sourceManagerName}Manager");
                $targetManager = $this->creationContext->get("{$targetManagerName}Manager");

                // check the map
                foreach ($map as $source => $target) {
                    if (false === $sourceManager->has($source)) {
                        throw new ServiceNotFoundException(
                            sprintf(
                                'Mapping source service with name "%s" not found in %s',
                                $source,
                                $sourceManagerName
                            )
                        );
                    }

                    if (false === $targetManager->has($target)) {
                        throw new ServiceNotFoundException(
                            sprintf(
                                'Mapping target service with name "%s" not found in %s',
                                $target,
                                $targetManagerName
                            )
                        );
                    }
                }

                $mappingConfig[$mapper] = $map;
            }
        }
        $this->mapping = $currentMapping->merge(new Config($mappingConfig))->toArray();

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

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return $this->mapping;
    }
}
