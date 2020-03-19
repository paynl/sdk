<?php

declare(strict_types=1);

namespace Codeception\TestAsset;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Dummy
 *
 * @package Codeception\TestAsset
 */
class DummyWithoutJsonSerializeImplementation
{
    use JsonSerializeTrait;
}
