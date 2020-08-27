<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

use PayNL\Sdk\{
    Config\Config,
    Exception\MapperSourceServiceNotFoundException,
    Exception\MapperTargetServiceNotFoundException,
    Service\AbstractPluginManager,
    Service\Manager as ServiceManager,
    Exception\ServiceNotFoundException,
    Exception\ServiceNotCreatedException,
    Util\Misc
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
     *
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     * @throws MapperSourceServiceNotFoundException
     * @throws MapperTargetServiceNotFoundException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
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
                preg_match_all('/((?:^|[A-Z])[a-z]+)/', Misc::getClassNameByFQN($mapper), $matches);
                if (2 > count($matches[1])) {
                    throw new ServiceNotFoundException(
                        sprintf(
                            'Mapper name "%s" is not valid',
                            $mapper
                        )
                    );
                }

                // determine the name of the source and target
                $sourceManagerName = lcfirst(current($matches[1]));
                next($matches[1]);
                $targetManagerName = lcfirst(current($matches[1]));

                $sourceManager = $this->creationContext->get("{$sourceManagerName}Manager");
                $targetManager = $this->creationContext->get("{$targetManagerName}Manager");

                // check the map
                foreach ($map as $source => $target) {
                    if (false === $sourceManager->has($source)) {
                        throw new MapperSourceServiceNotFoundException(
                            sprintf(
                                'Mapping source service with name "%s" not found in %s',
                                $source,
                                $sourceManagerName
                            )
                        );
                    }

                    if (false === $targetManager->has($target)) {
                        throw new MapperTargetServiceNotFoundException(
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
        if (true === isset($config['mapping'])) {
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
