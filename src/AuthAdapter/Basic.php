<?php

declare(strict_types=1);

namespace PayNL\Sdk\AuthAdapter;

use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class Basic
 *
 * @package PayNL\Sdk\Auth\Adapter
 */
class Basic implements AdapterInterface
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

//    /**
//     * Basic constructor.
//     *
//     * @param array $config
//     *
//     * @throws InvalidArgumentException
//     */
//    public function __construct(array $config)
//    {
//        $username = $password = '';
//
//        if (true === array_key_exists('username', $config)) {
//            $username = $config['username'];
//        }
//
//        if (true === array_key_exists('password', $config)) {
//            $password = $config['password'];
//        }
//
//        if (true === empty($username) || true === empty($password)) {
//            throw new InvalidArgumentException(
//                'Username and/ or password can not be empty'
//            );
//        }
//
//        $this->setUsername($username);
//        $this->setPassword($password);
//    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return Basic
     */
    public function setUsername(string $username): AdapterInterface
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return Basic
     */
    public function setPassword(string $password): AdapterInterface
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaderString(): string
    {
        return 'Basic ' . base64_encode("{$this->getUsername()}:{$this->getPassword()}");
    }
}
