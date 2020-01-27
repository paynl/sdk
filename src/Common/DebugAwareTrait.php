<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

/**
 * Trait DebugTrait
 *
 * Contains the necessary methods which are declared in the corresponding interface
 * @see DebugAwareInterface
 *
 * @package PayNL\Sdk
 */
trait DebugAwareTrait
{
    /**
     * @var boolean
     */
    protected $debug = false;

    /**
     * @inheritDoc
     */
    public function setDebug(bool $debug)
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isDebug(): bool
    {
        return true === $this->debug;
    }

    /**
     * Dumps the given arguments
     *
     * @param mixed ...$arguments
     *
     * @return void
     */
    public function dumpDebugInfo(...$arguments): void
    {
        ini_set('xdebug.overload_var_dump', 'off');
        if (true === function_exists('dump') && 0 !== strpos(get_class($this), 'Mock_')) {
            dump(...$arguments);
            return;
        }

        echo '<pre>';
        var_dump(...$arguments);
        echo '</pre>' . PHP_EOL;
    }
}
