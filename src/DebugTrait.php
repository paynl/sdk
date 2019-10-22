<?php

declare(strict_types=1);

namespace PayNL\Sdk;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

/**
 * Trait DebugTrait
 *
 * @package PayNL\Sdk
 */
trait DebugTrait
{
    /**
     * @var boolean
     */
    protected $debug = false;

    /**
     * @param boolean $debug
     *
     * @return self
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * @return boolean
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

        print '<pre>';
        var_dump(...$arguments);
        print '</pre>' . PHP_EOL;
    }
}
