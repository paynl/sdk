<?php

declare(strict_types=1);

namespace PayNL\Sdk\Config;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;
use PayNL\Sdk\Exception;
use PayNL\Sdk\Util\Misc;
use Zend\Stdlib\ArrayUtils;

/**
 * Class ConfigLoader
 *
 * @package PayNL\Sdk
 */
class Loader
{
    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @var array
     */
    protected $paths = [];

    /**
     * @var array
     */
    protected $mergedConfig = [];

    /**
     * Loader constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (true === array_key_exists('config_paths', $config) && true === is_array($config['config_paths'])) {
            $this->addPaths($config['config_paths']);
        }
        $this->mergedConfig = $config;
    }

    /**
     * @param array $paths
     *
     * @return Loader
     */
    public function addPaths(array $paths): self
    {
        foreach ($paths as $path) {
            $this->addPath($path);
        }
        return $this;
    }

    /**
     * @param string $path
     *
     * @return Loader
     */
    public function addPath(string $path): self
    {
        $this->paths[] = $path;
        return $this;
    }

    /**
     * @param string $path
     *
     * @return Loader
     */
    public function addConfigByPath(string $path): self
    {
        $class = Misc::getClassNameByFile($path);
        if (false === class_exists($class)) {
            throw new Exception\ConfigNotFoundException(
                sprintf(
                    'Config class with name "%s" can not be found',
                    $class
                )
            );
        }

        $instance = new $class();

        $this->addConfig($class, $instance);
        return $this;
    }

    /**
     * @param string $key
     * @param object $config
     *
     * @return Loader
     */
    protected function addConfig(string $key, $config): self
    {
        if (false === ($config instanceof ConfigProviderInterface)) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Config being merged must be instance of %s, %s given',
                    ConfigProviderInterface::class,
                    (is_object($config) ? get_class($config) : gettype($config))
                )
            );
        }

        $this->configs[$key] = $config;
        return $this;
    }

    /**
     * @return Loader
     */
    public function load(): self
    {
        foreach ($this->paths as $path) {
            $this->addConfigByPath($path);
        }

        foreach ($this->configs as $config) {
            $this->mergedConfig = ArrayUtils::merge($this->mergedConfig, $config());
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getMergedConfig(): array
    {
        return $this->mergedConfig;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }
}
