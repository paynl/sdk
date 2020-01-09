<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use Zend\Stdlib\ArrayUtils;

/**
 * Class Config
 *
 * @package PayNL\Sdk\Service
 */
class Config
{
    /**
     * @var array
     */
    protected $config = [
        'aliases'    => [],
        'factories'  => [],
        'initializers' => [],
        'invokables' => [],
        'mapping'    => [],
        'services'   => [],
    ];

    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach (array_keys($config) as $key) {
            if (false === array_key_exists($key, $this->config)) {
                unset($config[$key]);
            }
        }
        $this->config = ArrayUtils::merge($this->config, $config);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->config;
    }

    /**
     * @param Manager $serviceManger
     *
     * @return Manager
     */
    public function configureServiceManager(Manager $serviceManger): Manager
    {
        return $serviceManger->configure($this->config);
    }
}
