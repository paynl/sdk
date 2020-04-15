<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Model\ModelInterface;

/**
 * Class SecondFailingModel
 *
 * @package Codeception\TestAsset
 */
class SecondFailingModel implements ModelInterface
{
    /**
     * Some DocBlock info
     */
    protected $foo;
}
