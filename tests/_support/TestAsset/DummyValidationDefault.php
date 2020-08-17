<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Validator\ValidatorInterface;

/**
 * Class DummyQr
 *
 * @package Codeception\TestAsset
 */
class DummyValidationDefault implements DummyInterface, ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function isValid($value): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): array
    {
        return [];
    }
}