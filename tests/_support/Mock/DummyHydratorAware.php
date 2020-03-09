<?php

declare(strict_types=1);

namespace Codeception\Mock;

use Zend\Hydrator\HydratorAwareInterface;
use Zend\Hydrator\HydratorAwareTrait;

/**
 * Class DummyHydratorAware
 * @package Codeception\Mock
 */

class DummyHydratorAware implements HydratorAwareInterface
{
    use HydratorAwareTrait;
}