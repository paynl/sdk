<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Model\ModelInterface;

/**
 * Class FailingModel
 *
 * @package Codeception\TestAsset
 */
class FailingModel implements ModelInterface
{
    protected $foo;
}
