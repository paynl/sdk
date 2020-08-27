<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

/**
 * Class DummyMissingProperty
 *
 * @package Codeception\TestAsset
 */
class DummyMissingProperty implements DummyInterface
{

    /**
     * @required
     * @var int
     */
    protected $missingProperty;
}
