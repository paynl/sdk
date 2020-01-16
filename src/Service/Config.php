<?php

declare(strict_types=1);

namespace PayNL\Sdk\Service;

use Zend\Stdlib\ArrayUtils;
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

    public function __construct(array $config = [])
    {
        parent::__construct($this->config);

        foreach ($config as $key => $value) {
            if (false === in_array($key, $this->allowedKeys, true)) {
                unset($config[$key]);
            }
        }

        $this->merge(new parent($config));
    }

//    public function __construct($config = [])
//    {
//        if (true === is_array($this->config)) {
//            $this->config = new BaseConfig($config);
//        }
//
//        foreach (array_keys($config->toArray()) as $key) {
//            if (false === in_array($key, $this->allowedKeys, true)) {
//                unset($config[$key]);
//            }
//        }
//
//        $this->config->merge($config);// = ArrayUtils::merge($this->config, $config);
//    }

    /**
     * @return array
     */
//    public function toArray(): array
//    {
//        return $this->config;
//    }

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
