<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\Common\InvokableFactory;
use Zend\Stdlib\ArrayUtils;

/**
 * Class AbstractPluginManager
 *
 * @package PayNL\Sdk
 */
abstract class AbstractPluginManager extends Manager
{
    /**
     * @var string
     */
    protected $instanceOf = '';

    /**
     * AbstractPluginManager constructor.
     *
     * @param ContainerInterface|null $parentLocator
     * @param array $config
     */
    public function __construct($parentLocator = null, array $config = [])
    {
        if (true === array_key_exists('instance_of', $config) && true === is_string($config['instance_of'])) {
            $this->instanceOf = $config['instance_of'];
        }

        parent::__construct($config);

        $this->creationContext = $parentLocator instanceof ContainerInterface ? $parentLocator : $this;
    }

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

    public function validate($instance): void
    {
        if (true === empty($this->instanceOf) || $instance instanceof $this->instanceOf) {
            return;
        }

        throw new \Exception('Wrong class');
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
                throw new \Exception(sprintf('Plugin with name "%s" not found', $name));
            }

            $this->setFactory($name, InvokableFactory::class);
        }

        $instance = true === empty($options) ? parent::get($name) : $this->build($name, $options);
        $this->validate($instance);
        return $instance;
    }
}
