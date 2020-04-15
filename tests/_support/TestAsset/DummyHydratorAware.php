<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use Zend\Hydrator\HydratorAwareInterface;
use Zend\Hydrator\HydratorAwareTrait;

/**
 * Class DummyHydratorAware
 * @package Codeception\TestAsset
 */

class DummyHydratorAware implements HydratorAwareInterface
{
    use HydratorAwareTrait;
}