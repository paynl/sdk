<?php

declare(strict_types=1);

namespace PayNL\Sdk\AuthAdapter;

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
     */
    public function setUsername(string $username)
    {
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
     */
    public function setPassword(string $password)
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
