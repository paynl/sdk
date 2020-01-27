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
    /**
     * @return bool
     */
    public function isDebug(): bool;

    /**
     * @param bool $debug
     *
     * @return static
     */
    public function setDebug(bool $debug);
}
