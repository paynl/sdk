<?php

declare(strict_types=1);

namespace Helper;

use Exception,
    ReflectionClass,
    ReflectionException,
    Codeception\Module
;
use PHPUnit\Framework\Assert;

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

    /**
     * Check that the given $inputArray contains at least one of the key names given
     *  in $requiredKeys.
     *
     * @param array $inputArray
     * @param array $requiredKeys
     *
     * @return void
     */
    public function assertArrayHasAtLeastOneOfKeys(array $inputArray, array $requiredKeys): void
    {
        $inputKeys = array_keys($inputArray);
        $success = false;
        foreach ($requiredKeys as $requiredKey) {
            $success = Assert::contains($requiredKey)->evaluate($inputKeys, '', true);
            if (true === $success) {
                break;
            }
        }

        if (false === $success) {
            $this->fail(
                sprintf(
                    'Array should contain at least one of the following keys: "%s"',
                    implode('", "', $requiredKeys)
                )
            );
        }
    }

    /**
     * Check that the given $inputArray can only contains keys named in $allowedKeys.
     *
     * @param array $inputArray
     * @param array $allowedKeys
     *
     * @return void
     */
    public function assertArrayCanOnlyContainKeys(array $inputArray, array $allowedKeys): void
    {
        $inputKeys = array_keys($inputArray);
        $notAllowedKeys = array_diff($inputKeys, $allowedKeys);

        $success = Assert::isEmpty()->evaluate($notAllowedKeys, '', true);

        if (false === $success) {
            $this->fail(
                sprintf(
                    'Array contains keys which are not allowed. Allowed keys are "%s"',
                    implode('", "', $allowedKeys)
                )
            );
        }
    }
}
