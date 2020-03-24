<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Dummy
 *
 * @package Codeception\TestAsset
 */
class DummyJsonSerializable implements JsonSerializable
{
    use JsonSerializeTrait;

    public $foo = 'bar';
}
