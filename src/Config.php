<?php

declare(strict_types=1);

namespace PayNL\Sdk;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\LogicException;
use PayNL\Sdk\Exception\UnexpectedValueException;

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
     * @var array
     */
    protected $data = [
        self::KEY_API_URL  => '',
        self::KEY_USERNAME => '',
        self::KEY_PASSWORD => '',
    ];

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
        throw new LogicException('Config may not be cloned');
    }

    public function load(array $config): void
    {
        if (
            false === array_key_exists(self::KEY_API_URL, $config)
            || false === array_key_exists(self::KEY_USERNAME, $config)
            || false === array_key_exists(self::KEY_PASSWORD, $config)
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s, %s and %s need to be defined',
                    self::KEY_API_URL,
                    self::KEY_USERNAME,
                    self::KEY_PASSWORD
                )
            );
        }

        foreach ($config as $key => $value) {
            if (false === is_string($key)) {
                throw new UnexpectedValueException(
                    'Keys in the configuration must be a string'
                );
            }
            $this->set($key, $value);
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        if (false === array_key_exists($key, $this->data)) {
            return null;
        }

        return $this->data[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->get(self::KEY_API_URL);
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->get(self::KEY_USERNAME);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->get(self::KEY_PASSWORD);
    }
}
