<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

/**
 * Interface DebugAwareInterface
 *
 * @package PayNL\Sdk\Common
 */
interface DebugAwareInterface
{
    public function isDebug(): bool;

    public function setDebug(bool $debug);
}
