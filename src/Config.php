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

    public function load(array $config): self
    {
        if (true === array_key_exists('api_url', $config)) {
            $this->setApiUrl($config['api_url']);
        }

        if (true === array_key_exists('username', $config)) {
            $this->setUserName($config['username']);
        }

        if (true === array_key_exists('password', $config)) {
            $this->setPassword($config['password']);
        }

        return $this;
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
