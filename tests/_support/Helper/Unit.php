<?php

declare(strict_types=1);

namespace Helper;

use \Exception;
use \ReflectionClass;
use \ReflectionException;
use Codeception\Module;

/**
 * Class Unit
 *
 * here you can define custom actions
 * all public methods declared in helper class will be available in $I
 *
 * @package Helper
 */
class Unit extends Module
{
    /**
     * @param object $object
     * @param string $methodName
     * @param array $parameters
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function invokeMethod($object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @param $object
     * @param string $methodName
     *
     * @throws ReflectionException
     *
     * @return string
     */
    public function getMethodAccessibility($object, string $methodName): string
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        if (true === $method->isPrivate()) {
            return 'private';
        }

        if (true === $method->isProtected()) {
            return 'protected';
        }

        return 'public';
    }
}