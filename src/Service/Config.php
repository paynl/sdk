<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use PayNL\Sdk\Config\Config as BaseConfig;

/**
 * Class Config
 *
 * @package PayNL\Sdk\Service
 */
class Config extends BaseConfig
{
    /**
     * @var array
     */
    protected $allowedKeys = [
        'aliases',
        'factories',
        'initializers',
        'invokables',
        'mapping',
        'services',
    ];

    /**
     * @var array
     */
    protected $config = [
        'aliases'      => [],
        'factories'    => [],
        'initializers' => [],
        'invokables'   => [],
        'mapping'      => [],
        'services'     => [],
    ];

    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($this->config);

        foreach (array_keys($config) as $key) {
            if (false === in_array($key, $this->allowedKeys, true)) {
                unset($config[$key]);
            }
        }

        $this->merge(new BaseConfig($config));
    }

    /**
     * @param Manager $serviceManger
     *
     * @return Manager
     */
    public function configureServiceManager(Manager $serviceManger): Manager
    {
        return $serviceManger->configure($this->toArray());
    }
}
