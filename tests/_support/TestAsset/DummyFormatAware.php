<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Common\FormatAwareInterface;
use PayNL\Sdk\Common\FormatAwareTrait;

/**
 * Class DummyFormatAware
 *
 * @package Codeception\TestAsset
 */
class DummyFormatAware implements FormatAwareInterface
{
    use FormatAwareTrait;
}
