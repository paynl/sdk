<?php

declare(strict_types=1);

namespace PayNL\Sdk;

/**
 * Class Config
 *
 * @package PayNL\Sdk
 */
class Config
{
    /*
     * Configuration key constants definition
     */
    public const KEY_API_URL = 'api_url';
    public const KEY_USERNAME = 'username';
    public const KEY_PASSWORD = 'password';

    /**
     * @var Config
     */
    protected static $instance;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $password;

    /**
     * @return Config
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Config constructor.
     */
    protected function __construct()
    {
        // to prevent new instances - singleton pattern
    }

    /**
     * @return void
     */
    private function __clone()
    {
        // to prevent object copies - singleton pattern
    }

    public function load(array $config): void
    {
        if (true === array_key_exists(self::KEY_API_URL, $config)) {
            $this->setApiUrl($config[self::KEY_API_URL]);
        }

        if (true === array_key_exists(self::KEY_USERNAME, $config)) {
            $this->setUserName($config[self::KEY_USERNAME]);
        }

        if (true === array_key_exists(self::KEY_PASSWORD, $config)) {
            $this->setPassword($config[self::KEY_PASSWORD]);
        }
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param mixed $apiUrl
     *
     * @return Config
     */
    public function setApiUrl($apiUrl): self
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     *
     * @return Config
     */
    public function setUserName($userName): self
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return Config
     */
    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }
}
