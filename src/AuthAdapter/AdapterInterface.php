<?php

declare(strict_types=1);

namespace PayNL\Sdk\AuthAdapter;

/**
 * Interface AdapterInterface
 *
 * @package PayNL\Sdk\Auth
 */
interface AdapterInterface
{
    public function getUsername(): string;

    public function setUsername(string $username): self;

    public function getPassword(): string;

    public function setPassword(string $password): self;

    /**
     * Returns the string which can be used for an authorization header
     *
     * @return string
     */
    public function getHeaderString(): string;
}
