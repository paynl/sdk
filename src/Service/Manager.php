<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Common\InitializerInterface,
    Common\InvokableFactory,
    Exception\ContainerModificationsNotAllowedException,
    Exception\CyclicAliasException,
    Exception\InvalidArgumentException,
    Exception\ServiceNotCreatedException,
    Exception\ServiceNotFoundException
};
use Exception as stdException;

/**
 * Class Manager
 *
 * @package PayNL\Sdk
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Manager implements ContainerInterface
{
    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * @var ContainerInterface
     */
    protected $creationContext;

    /**
     * Whether or not changes may be made to this instance.
     *
     * @var boolean
     */
    protected $allowOverride = false;

    /**
     * @var array
     */
    protected $factories = [];

    /**
     * @var array
     */
    protected $initializers = [];

    /**
     * @var array
     */
    protected $resolvedAliases = [];

    /**
     * @var array
     */
    protected $services = [];

    /**
     * @var boolean
     */
    protected $configured = false;

    /**
     * ServiceManager constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->creationContext = $this;
        $this->configure($config);
    }

    /**
     * @param array $config
     *
     * @return Manager
     */
    public function configure(array $config): self
    {
        $this->validateOverrides($config);

        if (true === isset($config['services'])) {
            $this->services = array_merge($config['services'], $this->services);
        }

        if (false === empty($config['invokables'])) {
            $aliases = $this->createAliasesForInvokables($config['invokables']);
            $factories = $this->createFactoriesForInvokables($config['invokables']);

            if (false === empty($aliases)) {
                $config['aliases'] = array_merge($config['aliases'] ?? [], $aliases);
            }

            $config['factories'] = array_merge($config['factories'] ?? [], $factories);
        }

        if (true === isset($config['factories'])) {
            $this->factories = array_merge($config['factories'], $this->factories);
        }

        if (true === isset($config['aliases'])) {
            $this->configureAliases($config['aliases']);
        } elseif (false === $this->configured && 0 < count($this->aliases)) {
            $this->resolveAliases($this->aliases);
        }

        if (true === isset($config['initializers'])) {
            $this->resolveInitializers($config['initializers']);
        }

        $this->configured = true;

        return $this;
    }

    /**
     * @param array $invokables
     *
     * @return array
     */
    private function createAliasesForInvokables(array $invokables): array
    {
        $aliases = [];
        foreach ($invokables as $name => $class) {
            if ($name === $class) {
                continue;
            }
            $aliases[$name] = $class;
        }
        return $aliases;
    }

    /**
     * @param array $invokables
     *
     * @return array
     */
    private function createFactoriesForInvokables(array $invokables): array
    {
        $factories = [];
        foreach ($invokables as $name => $class) {
            if ($name === $class) {
                $factories[$name] = InvokableFactory::class;
                continue;
            }
            $factories[$class] = InvokableFactory::class;
        }
        return $factories;
    }

    /**
     * @param array $aliases
     *
     * @return void
     */
    private function configureAliases(array $aliases): void
    {
        if (false === $this->configured) {
            $this->aliases = array_merge($aliases, $this->aliases);
            $this->resolveAliases($this->aliases);

            return;
        }

        $intersecting = false === empty($this->aliases) && array_intersect_key($this->aliases, $aliases);
        $this->aliases = array_merge($this->aliases, $aliases);

        if (true === $intersecting) {
            $this->resolveAliases($this->aliases);
            return;
        }

        $this->resolveAliases($aliases);
        $this->resolveNewAliasesWithPreviouslyResolvedAliases($aliases);
    }

    /**
     * @param array $aliases
     *
     * @throws CyclicAliasException
     *
     * @return void
     */
    private function resolveAliases(array $aliases): void
    {
        foreach (array_keys($aliases) as $alias) {
            $visited = [];
            $name = $alias;

            while (true === isset($this->aliases[$name])) {
                if (true === isset($visited[$name])) {
                    throw new CyclicAliasException(
                        sprintf(
                            'Cycle(s) were detected in provided aliases for %s',
                            $name
                        )
                    );
                }

                $visited[$name] = true;
                $name = $this->aliases[$name];
            }

            $this->resolvedAliases[$alias] = $name;
        }
    }

    /**
     * @param array $aliases
     *
     * @return void
     */
    private function resolveNewAliasesWithPreviouslyResolvedAliases(array $aliases): void
    {
        foreach ($this->resolvedAliases as $name => $target) {
            if (true === isset($aliases[$target])) {
                $this->resolvedAliases[$name] = $this->resolvedAliases[$target];
            }
        }
    }

    /**
     * @param array $initializers
     *
     * @throws InvalidArgumentException when the initializer can not be found/loaded or is not a callable object
     *
     * @return void
     */
    private function resolveInitializers(array $initializers): void
    {
        foreach ($initializers as $initializer) {
            if (true === is_string($initializer) && true === class_exists($initializer)) {
                $initializer = new $initializer();
            }

            if (true === is_callable($initializer)) {
                $this->initializers[] = $initializer;
                continue;
            }

            // Error section
            if (true === is_string($initializer)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'An invalid initializer was registered; resolved to class or function "%s" ' .
                        'which does not exist. Please provide a valid function name or class name ' .
                        'resolving to an implementation of %s',
                        $initializer,
                        InitializerInterface::class
                    )
                );
            }

            throw new InvalidArgumentException(
                sprintf(
                    'An invalid initializer was registered. Expected a callable, or an instance of "%s", got "%s"',
                    InitializerInterface::class,
                    (is_object($initializer) === true ? get_class($initializer) : gettype($initializer))
                )
            );
        }
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when given name is not a string
     */
    public function has($name): bool
    {
        if (false === is_string($name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given name to "%s" must be a string, %s given',
                    __METHOD__,
                    gettype($name)
                )
            );
        }

        $name = $this->resolvedAliases[$name] ?? $name;

        return isset($this->services[$name]) || isset($this->factories[$name]);
    }

    /**
     * @inheritDoc
     */
    public function get($name)
    {
        $requestedName = $name;

        if (true === isset($this->services[$name])) {
            return $this->services[$name];
        }

        $name = $this->resolvedAliases[$name] ?? $name;

        if ($requestedName !== $name && true === isset($this->services[$name])) {
            $this->services[$requestedName] = $this->services[$name];
            return $this->services[$name];
        }

        $object = $this->doCreate($name);

        if ($requestedName !== $name) {
            $this->services[$requestedName] = $object;
        }

        return $object;
    }

    /**
     * @param string $name
     * @param array|null $options
     *
     * @return mixed
     */
    public function build(string $name, array $options = null)
    {
        // do not "cache" because of context specific options
        $name = $this->resolvedAliases[$name] ?? $name;
        return $this->doCreate($name, $options);
    }

    /**
     * Indicate whether or not the instance is immutable.
     *
     * @param bool $allow
     *
     * @return Manager
     */
    public function setAllowOverride(bool $allow): self
    {
        $this->allowOverride = $allow;
        return $this;
    }

    /**
     * Retrieve the flag indicating immutability status.
     *
     * @return bool
     */
    public function hasAllowOverride(): bool
    {
        return $this->allowOverride;
    }

    /**
     * @param string $resolvedName
     * @param array|null $options
     *
     * @throws ServiceNotCreatedException
     *
     * @return mixed
     */
    public function doCreate(string $resolvedName, array $options = null)
    {
        try {
            $factory = $this->getFactory($resolvedName);
            $instance = $factory($this->creationContext, $resolvedName, $options);
        } catch (stdException $exception) {
            throw new ServiceNotCreatedException(
                sprintf(
                    'Service with name "%s" is not created because of %s',
                    $resolvedName,
                    $exception->getMessage()
                ),
                (int)$exception->getCode(),
                $exception
            );
        }

        foreach ($this->initializers as $initializer) {
            $initializer($this->creationContext, $instance);
        }

        return $instance;
    }

    /**
     * @param string $name
     *
     * @throws ServiceNotFoundException
     *
     * @return callable
     */
    public function getFactory(string $name): callable
    {
        $factory = $this->factories[$name] ?? null;

        $lazyLoaded = false;
        if (true === is_string($factory) && true === class_exists($factory)) {
            $factory = new $factory();
            $lazyLoaded = true;
        }

        if (true === is_callable($factory)) {
            if (true === $lazyLoaded) {
                $this->factories[$name] = $factory;
            }
            return $factory;
        }

        throw new ServiceNotFoundException(
            sprintf(
                'Unable to resolve service "%s" to a factory',
                $name
            )
        );
    }

    /**
     * @param string $name
     * @param object $service
     *
     * @return void
     */
    public function setService(string $name, $service): void
    {
        $this->configure(['services' => [$name => $service]]);
    }

    /**
     * @param string $name
     * @param string|callable $factory
     *
     * @return void
     */
    public function setFactory(string $name, $factory): void
    {
        $this->configure(['factories' => [$name => $factory]]);
    }

    /**
     * @param string $alias
     * @param string $target
     *
     * @return void
     */
    public function setAlias(string $alias, $target): void
    {
        $this->configure(['aliases' => [$alias => $target]]);
    }

    /**
     * @param string|callable $initializer
     *
     * @return void
     */
    public function addInitializer($initializer): void
    {
        $this->configure(['initializers' => [$initializer]]);
    }

    /**
     * @param array $config
     *
     * @return void
     */
    protected function validateOverrides(array $config): void
    {
        if (true === $this->allowOverride || false === $this->configured) {
            return;
        }

        if (true === isset($config['services'])) {
            $this->validateOverrideSet(array_keys($config['services']), 'service');
        }

        if (true === isset($config['aliases'])) {
            $this->validateOverrideSet(array_keys($config['aliases']), 'alias');
        }

        if (true === isset($config['invokables'])) {
            $this->validateOverrideSet(array_keys($config['invokables']), 'invokable class');
        }

        if (true === isset($config['factories'])) {
            $this->validateOverrideSet(array_keys($config['factories']), 'factory');
        }
    }

    /**
     * @param array $services
     * @param string $type
     *
     * @throws ContainerModificationsNotAllowedException
     *
     * @return void
     */
    protected function validateOverrideSet(array $services, string $type): void
    {
        $detected = [];
        foreach ($services as $service) {
            if (true === isset($this->services[$service])) {
                $detected[] = $service;
            }
        }

        if (true === empty($detected)) {
            return;
        }

        throw new ContainerModificationsNotAllowedException(
            sprintf(
                'An updated/new %s is not allowed because the container does not allow changes for already ' .
                'existing instances. The following already exist in the container: %s',
                $type,
                implode(', ', $detected)
            )
        );
    }
}
