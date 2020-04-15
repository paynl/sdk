<?php

namespace Codeception\Module;

use Codeception\Configuration;
use Codeception\Exception\ConfigurationException;
use Codeception\Lib\Interfaces\PartedModule;
use Codeception\Module as CodeceptionModule;
use Codeception\TestInterface;
use Mockery;
use PayNL\Sdk\Service\Manager as ServiceManager;
use PayNL\Sdk\Config\Config;
use PayNL\Sdk\Application\Application;
use Codeception\Lib\Connector\Sdk as SdkConnector;

/**
 * Class Sdk
 *
 * @package Codeception\Module
 *
 *
 * config: relative path to config file (default: `tests/config.php`)
 */
class Sdk extends CodeceptionModule implements PartedModule
{
    protected $config = [
        'config' => 'tests/config.php',
        'recreateApplicationBetweenTests' => true,
    ];

    protected $requiredFields = [];

    /**
     * @var SdkConnector
     */
    public $client;

    /**
     * @var Config|array
     */
    public $configuration;

    /**
     * @var Application
     */
    public $application;

    /**
     * @var ServiceManager
     */
    public $serviceManager;

    /**
     * @inheritDoc
     *
     * @throws ConfigurationException
     */
    public function _initialize(): void
    {
        $configFile = Configuration::projectDir() . $this->config['config'];
        if (false === file_exists($configFile)) {
            throw new ConfigurationException(
                sprintf(
                    'Can not find the tests configuration file in "%s"',
                    $configFile
                )
            );
        }

        $this->configuration = new Config(require $configFile);

        $this->client = new SdkConnector();
        $this->client->setApplicationConfig($this->configuration);

        if (false === ($this->config['recreateApplicationBetweenTests'] ?? true)) {
            $this->application = $this->client->initApplication();
            $this->serviceManager = $this->application->getServiceManager();
        }
    }

    /**
     * @inheritDoc
     */
    public function _before(TestInterface $test): void
    {
        if ($this->config['recreateApplicationBetweenTests'] ?? true) {
            $this->application = $this->client->initApplication();
            $this->serviceManager = $this->application->getServiceManager();
        } elseif (true === isset($this->application)) {
            $this->client->setApplication($this->application);
        }
    }

    public function grabService(string $name)
    {
        return $this->client->grabServiceFromContainer($name);
    }

    public function grabMockService(string $name): Mockery\MockInterface
    {
        return $this->client->grabMockedServiceFromContainer($name);
    }

    /**
     * @return array|Config
     */
    public function getConfig()
    {
        return $this->configuration;
    }

    public function getApplication(): Application
    {
        return $this->client->getApplication();
    }

    public function getServiceManager(): ServiceManager
    {
        return $this->client->getServiceManager();
    }

    /**
     * @inheritDoc
     */
    public function _afterSuite(): void
    {
        unset($this->client);
    }

    /**
     * @inheritDoc
     */
    public function _parts(): array
    {
        return ['services'];
    }
}
