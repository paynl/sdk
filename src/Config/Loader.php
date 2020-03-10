<?php

declare(strict_types=1);

namespace PayNL\Sdk\Config;

use Traversable;
use PayNL\Sdk\{
    Config\ProviderInterface as ConfigProviderInterface,
    Exception,
    Util\Misc
};

/**
 * Class ConfigLoader
 *
 * Loads all the configurations for the given config paths which must be callable objects (Config
 * Providers)
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
     * @var Config
     */
    protected $applicationConfig;

    /**
     * @var Config
     */
    protected $mergedConfig;

    /**
     * Loader constructor.
     *
     * @param array|Config $applicationConfig
     */
    public function __construct($applicationConfig = [])
    {
        if (true === is_array($applicationConfig)) {
            $applicationConfig = new Config($applicationConfig);
        } elseif (! ($applicationConfig instanceof Config)) {
            throw new Exception\InvalidArgumentException('Config not correct');
        }

        if (true === $applicationConfig->has('config_paths')) {
            $this->addPaths($applicationConfig->get('config_paths'));
        }

        $this->mergedConfig = new Config();
        $this->applicationConfig = $applicationConfig;
    }

    /**
     * @param string|array|Traversable $paths
     *
     * @return Loader
     */
    public function addPaths($paths): self
    {
        if (true === is_string($paths)) {
            $paths = [$paths];
        } elseif (! is_iterable($paths)) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Given paths to "%s" must be iterable',
                    __METHOD__
                )
            );
        }

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
     * @return array
     */
    protected function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * @param string $path
     *
     * @return Loader
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
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
     * @param ConfigProviderInterface $config
     *
     * @return Loader
     */
    protected function addConfig(string $key, ConfigProviderInterface $config): self
    {
        $this->configs[$key] = $config;
        return $this;
    }

    /**
     * @return Loader
     */
    public function load(): self
    {
        foreach ($this->getPaths() as $path) {
            $this->addConfigByPath($path);
        }

        foreach ($this->configs as $config) {
            $providerConfig = $config();

            if (false === $providerConfig instanceof Config) {
                $providerConfig = new Config($providerConfig);
            }
            $this->mergedConfig->merge($providerConfig);
        }

        $this->mergedConfig->merge($this->applicationConfig);

        return $this;
    }

    /**
     * @return Config
     */
    public function getMergedConfig(): Config
    {
        return $this->mergedConfig;
    }

    /**
     * Collection of the providers given
     *
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }
}
