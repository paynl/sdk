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

    /**
     * Basic constructor.
     *
     * @param string $username
     * @param string $password
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $username, string $password)
    {
        if (true === empty($username) || true === empty($password)) {
            throw new InvalidArgumentException(
                'Username and/ or password can not be empty'
            );
        }

        $this->setUsername($username);
        $this->setPassword($password);
    }

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
    protected function setUsername(string $username): self
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
    protected function setPassword(string $password): self
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
