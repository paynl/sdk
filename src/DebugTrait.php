<?php
declare(strict_types=1);

namespace PayNL\Sdk;

/**
 * Trait DebugTrait
 *
 * @package PayNL\Sdk
 */
trait DebugTrait
{
    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @return bool
     */
    public function getDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     *
     * @return self
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return true === $this->getDebug();
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
        $function = 'var_dump';
        $dumpString = '<pre>%s</pre>' . PHP_EOL;
        if (true === function_exists('dump')) {
            $function = 'dump';
            $dumpString = '';
        }

        echo sprintf(
            $dumpString,
            $function(...$arguments)
        );
    }
}
