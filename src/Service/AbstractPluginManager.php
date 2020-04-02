<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Common\InvokableFactory,
    Exception\InvalidServiceException,
    Exception\ServiceNotFoundException
};

/**
 * Class AbstractPluginManager
 *
 * @package PayNL\Sdk
 */
abstract class AbstractPluginManager extends Manager
{
    /**
     * Class name that the created instance must be instanced of
     *
     * @var string
     */
    protected $instanceOf = '';

    /**
     * @var string
     */
    protected $configKey = '';

    /**
     * AbstractPluginManager constructor.
     *
     * @param ContainerInterface|null $parentLocator
     * @param array $config
     */
    public function __construct($parentLocator = null, array $config = [])
    {
        parent::__construct($config);

        $this->creationContext = $parentLocator instanceof ContainerInterface ? $parentLocator : $this;

        $this->setConfigKey($config['loader_options']['config_key'] ?? '');
    }

    /**
     * Override configure method so it can validate the service instances.
     *
     * If an instance passed to the services configuration is invalid for the plugin manager it will
     *  throw an InvalidServiceException
     *
     * @inheritDoc
     */
    public function configure(array $config): Manager
    {
        if (true === isset($config['services'])) {
            foreach ($config['services'] as $service) {
                $this->validate($service);
            }
        }

        parent::configure($config);

        return $this;
    }

    /**
     * Validate the given instance if its suffices the set "instanceOf" property
     *
     * @param mixed $instance
     *
     * @throws InvalidServiceException when the plugin created is invalid for the plugin context
     *
     * @return void
     */
    public function validate($instance): void
    {
        $instanceOf = $this->getInstanceOf();
        if (true === empty($instanceOf) || $instance instanceof $instanceOf) {
            return;
        }

        throw new InvalidServiceException(
            sprintf(
                'Plugin manager "%s" expects an instance of "%s", but "%s" was given',
                __CLASS__,
                $this->instanceOf,
                true === is_object($instance) ? get_class($instance) : gettype($instance)
            )
        );
    }

    /**
     * @return string
     */
    protected function getInstanceOf(): string
    {
        return $this->instanceOf;
    }

    /**
     * @return string
     */
    public function getConfigKey(): string
    {
        return $this->configKey;
    }

    /**
     * @param string $configKey
     *
     * @return AbstractPluginManager
     */
    protected function setConfigKey(string $configKey): self
    {
        $this->configKey = $configKey;
        return $this;
    }

    /**
     * @inheritDoc
     *
     * @param array|null $options
     */
    public function get($name, array $options = null)
    {
        if (false === $this->has($name)) {
            if (false === class_exists($name)) {
                throw new ServiceNotFoundException(
                    sprintf(
                        'Plugin with name "%s" not found in plugin manager "%s"',
                        $name,
                        static::class
                    )
                );
            }

            $this->setFactory($name, InvokableFactory::class);
        }

        $instance = (true === empty($options) ? parent::get($name) : $this->build($name, $options));
        $this->validate($instance);
        return $instance;
    }

    /**
     * Extend the parent so it can validate that the created instance validates the
     *  set "instanceOf"
     *
     * @inheritDoc
     */
    public function build(string $name, array $options = null)
    {
        $instance = parent::build($name, $options);
        $this->validate($instance);
        return $instance;
    }
}
