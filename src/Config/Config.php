<?php

declare(strict_types=1);

namespace PayNL\Sdk\Config;

use PayNL\Sdk\{
    Exception\LogicException,
    Exception\UnexpectedValueException
};

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
     * @var array
     */
    protected $data = [];

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
     * @throws LogicException
     *
     * @return void
     */
    private function __clone()
    {
        // to prevent object copies - singleton pattern
        throw new LogicException('Config may not be cloned');
    }

    /**
     * @param array $config
     *
     * @return void
     */
    public function load(array $config): void
    {
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
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
