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
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     */
    public function setUsername(string $username)
    {
        if ('' === $username) {
            throw new InvalidArgumentException(
                'Given username can not be empty'
            );
        }

        $this->username = $username;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     */
    public function setPassword(string $password)
    {
        if ('' === $password) {
            throw new InvalidArgumentException(
                'Given password can not be empty'
            );
        }

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
