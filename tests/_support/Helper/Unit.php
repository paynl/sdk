<?php

declare(strict_types=1);

namespace Helper;


use PHPUnit\Framework\Constraint\IsEqual;
use ReflectionProperty, ReflectionMethod;
use Exception,
    ReflectionClass,
    ReflectionException,
    Codeception\Module
;
use PHPUnit\Util\InvalidArgumentHelper, PHPUnit\Framework\Exception as PHPUnitFrameworkException;
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
    /* Visibility constants definitions */
    protected const VISIBILITY_PUBLIC    = 'public';
    protected const VISIBILITY_PROTECTED = 'protected';
    protected const VISIBILITY_PRIVATE   = 'private';

    /* Error constants definitions */
    protected const ERROR_CLASS_NOT_ABSTRACT            = 1000;
    protected const ERROR_CLASS_HAS_TOO_MUCH_PROPERTIES = 1001;
    protected const ERROR_CLASS_HAS_TOO_LESS_PROPERTIES = 1002;

    protected const ERROR_NOT_AN_OBJECT                 = 2000;

    protected const ERROR_METHOD_MISSING                = 3000;
    protected const ERROR_METHOD_VISIBILITY             = 3001;
    protected const ERROR_METHOD_NOT_ABSTRACT           = 3010;
    protected const ERROR_METHOD_NOT_FINAL              = 3020;
    protected const ERROR_METHOD_NOT_STATIC             = 3030;

    protected const ERROR_ARRAY_MUST_CONTAIN_AT_LEAST   = 4000;
    protected const ERROR_ARRAY_CAN_ONLY_CONTAIN        = 4001;
    protected const ERROR_ARRAY_MISSING_KEYS            = 4002;

    /**
     * Collection of possible error messages
     *
     * @var array
     */
    protected $errorTemplates = array(
        self::ERROR_METHOD_VISIBILITY             => 'Method %s on %s should be %s',
        self::ERROR_METHOD_MISSING                => 'Class %s is missing method "%s"',
        self::ERROR_NOT_AN_OBJECT                 => 'An object must be given, got %s',
        self::ERROR_CLASS_NOT_ABSTRACT            => 'Class %s is not declared abstract',
        self::ERROR_CLASS_HAS_TOO_MUCH_PROPERTIES => 'The properties "%s" are added to %s',
        self::ERROR_CLASS_HAS_TOO_LESS_PROPERTIES => 'The properties "%s" are missing in %s',
        self::ERROR_METHOD_NOT_ABSTRACT           => 'Method %s should be declared as abstract',
        self::ERROR_METHOD_NOT_FINAL              => 'Method %s should be declared as final',
        self::ERROR_METHOD_NOT_STATIC             => 'Method %s should be declared as static',
        self::ERROR_ARRAY_MUST_CONTAIN_AT_LEAST   => 'Array should contain at least one of the following keys: "%s"',
        self::ERROR_ARRAY_CAN_ONLY_CONTAIN        => 'Array contains keys which are not allowed. Allowed keys are "%s"',
        self::ERROR_ARRAY_MISSING_KEYS            => 'Array is missing key(s) "%s"',
    );

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
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(1, 'object');
        }

        if (false === is_string($methodName)) {
            throw InvalidArgumentHelper::factory(2, 'string');
        }

        $method = $this->getReflectionMethod(get_class($object), $methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @param object $object
     * @param string $methodName
     *
     * @throws ReflectionException
     *
     * @return string
     */
    public function getMethodAccessibility($object, string $methodName): string
    {
        $method = $this->getReflectionMethod(get_class($object), $methodName);
        if (true === $method->isPrivate()) {
            return self::VISIBILITY_PRIVATE;
        }

        if (true === $method->isProtected()) {
            return self::VISIBILITY_PROTECTED;
        }

        return self::VISIBILITY_PUBLIC;
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
                    $this->errorTemplates[self::ERROR_ARRAY_MUST_CONTAIN_AT_LEAST],
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
                    $this->errorTemplates[self::ERROR_ARRAY_CAN_ONLY_CONTAIN],
                    implode('", "', $allowedKeys)
                )
            );
        }
    }

    /**
     * @param array $inputArray
     * @param array $mandatoryKeys
     *
     * @return void
     */
    public function assertArrayMustContainKeys(array $inputArray, array $mandatoryKeys): void
    {
        $inputKeys = array_keys($inputArray);

        $diff = array_diff($mandatoryKeys, $inputKeys);

        $success = (new IsEqual(0))->evaluate(count($diff), '', true);

        if (false === $success) {
            $this->fail(
                sprintf(
                    $this->errorTemplates[self::ERROR_ARRAY_MISSING_KEYS],
                    implode('", "', $diff)
                )
            );
        }
    }

    /**
     * Verify if the given properties are present on the given object, if not the assertion will fail
     * and the message will be triggered. Otherwise if the object's got properties which are missing
     * in the given array of properties the assertion will also fail and a message will be shown.
     *
     * @param object $object
     * @param array $properties
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectAttributesEquals($object, array $properties): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(1, 'object');
        }

        $reflection = new ReflectionClass(get_class($object));
        $reflectionProperties = $reflection->getProperties();

        $reflectionProperties = array_map(function($item) {
            /** @var ReflectionProperty $item */
            return $item->getName();
        }, $reflectionProperties);

        $reflectionProperties = array_filter($reflectionProperties, function($var) {
            return 0 !== strpos($var, '__phpunit');
        });

        // TODO: split to separate methods, e.g. assertObjectsHasAddedProperties, etc.
        $addedProperties = array_diff($reflectionProperties, $properties);
        Assert::assertCount(
            0,
            $addedProperties,
            sprintf(
                $this->errorTemplates[self::ERROR_CLASS_HAS_TOO_MUCH_PROPERTIES],
                implode(', ', $addedProperties),
                get_class($object)
            )
        );

        $missingProperties = array_diff($properties, $reflectionProperties);
        Assert::assertCount(
            0,
            $missingProperties,
            sprintf(
                $this->errorTemplates[self::ERROR_CLASS_HAS_TOO_LESS_PROPERTIES],
                implode(', ', $missingProperties),
                get_class($object)
            )
        );
    }

    /**
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassIsAbstract($className): void
    {
        if (false === is_string($className) || false === class_exists($className, false)) {
            throw InvalidArgumentHelper::factory(2, 'class name');
        }

        $reflectionClass = new ReflectionClass($className);
        Assert::assertTrue(
            $reflectionClass->isAbstract(),
            sprintf(
                $this->errorTemplates[self::ERROR_CLASS_NOT_ABSTRACT],
                $className
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassHasMethod($methodName, $className): void
    {
        $this->validateClassMethod($methodName, $className);

        $reflectionClass = new ReflectionClass($className);
        Assert::assertTrue(
            $reflectionClass->hasMethod($methodName),
            sprintf(
                $this->errorTemplates[self::ERROR_METHOD_MISSING],
                $className,
                $methodName
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassMethodIsPrivate($methodName, $className): void
    {
        $this->assertClassHasMethod($methodName, $className);

        $reflectionMethod = $this->getReflectionMethod($className, $methodName);
        Assert::assertTrue(
            $reflectionMethod->isPrivate(),
            sprintf(
                $this->errorTemplates[self::ERROR_METHOD_VISIBILITY],
                $methodName,
                $className,
                self::VISIBILITY_PRIVATE
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassMethodIsProtected($methodName, $className): void
    {
        $this->assertClassHasMethod($methodName, $className);

        $reflectionMethod = $this->getReflectionMethod($className, $methodName);
        Assert::assertTrue(
            $reflectionMethod->isProtected(),
            sprintf(
                $this->errorTemplates[self::ERROR_METHOD_VISIBILITY],
                $methodName,
                $className,
                self::VISIBILITY_PROTECTED
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassMethodIsPublic($methodName, $className): void
    {
        $this->assertClassHasMethod($methodName, $className);

        $reflectionMethod = $this->getReflectionMethod($className, $methodName);
        Assert::assertTrue(
            $reflectionMethod->isPublic(),
            sprintf(
                $this->errorTemplates[self::ERROR_METHOD_VISIBILITY],
                $methodName,
                $className,
                self::VISIBILITY_PUBLIC
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassMethodIsAbstract($methodName, $className): void
    {
        $this->assertClassHasMethod($methodName, $className);

        $reflectionMethod = $this->getReflectionMethod($className, $methodName);
        Assert::assertTrue(
            $reflectionMethod->isPublic(),
            sprintf(
                $this->errorTemplates[self::ERROR_METHOD_NOT_ABSTRACT],
                "{$className}::{$methodName}"
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassMethodIsFinal($methodName, $className): void
    {
        $this->assertClassHasMethod($methodName, $className);

        $reflectionMethod = $this->getReflectionMethod($className, $methodName);
        Assert::assertTrue(
            $reflectionMethod->isFinal(),
            sprintf(
                $this->errorTemplates[self::ERROR_METHOD_NOT_FINAL],
                "{$className}::{$methodName}"
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertClassMethodIsStatic($methodName, $className): void
    {
        $this->assertClassHasMethod($methodName, $className);

        $reflectionMethod = $this->getReflectionMethod($className, $methodName);
        Assert::assertTrue(
            $reflectionMethod->isStatic(),
            sprintf(
                $this->errorTemplates[self::ERROR_METHOD_NOT_STATIC],
                "{$className}::{$methodName}"
            )
        );
    }

    /**
     * @param string $methodName
     * @param string $className
     *
     * @throws PHPUnitFrameworkException
     *
     * @return void
     */
    protected function validateClassMethod($methodName, $className): void
    {
        if (false === is_string($methodName)) {
            throw InvalidArgumentHelper::factory(1, 'string');
        }

        if (false === is_string($className) || false === class_exists($className, false)) {
            throw InvalidArgumentHelper::factory(2, 'class name');
        }
    }

    /**
     * @param string $methodName
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectHasMethod($methodName, $object): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(2, 'object');
        }

        $this->assertClassHasMethod($methodName, get_class($object));
    }

    /**
     * @param string $methodName
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectMethodIsPrivate($methodName, $object): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(2, 'object');
        }

        $this->assertClassMethodIsPrivate($methodName, get_class($object));
    }

    /**
     * @param string $methodName
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectMethodIsProtected($methodName, $object): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(2, 'object');
        }

        $this->assertClassMethodIsProtected($methodName, get_class($object));
    }

    /**
     * @param string $methodName
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectMethodIsPublic($methodName, $object): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(2, 'object');
        }

        $this->assertClassMethodIsPublic($methodName, get_class($object));
    }

    /**
     * @param string $methodName
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectMethodIsAbstract($methodName, $object): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(2, 'object');
        }

        $this->assertClassMethodIsAbstract($methodName, get_class($object));
    }

    /**
     * @param string $methodName
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectMethodIsFinal($methodName, $object): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(2, 'object');
        }

        $this->assertClassMethodIsFinal($methodName, get_class($object));
    }

    /**
     * @param string $methodName
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function assertObjectMethodIsStatic($methodName, $object): void
    {
        if (false === is_object($object)) {
            throw InvalidArgumentHelper::factory(2, 'object');
        }

        $this->assertClassMethodIsStatic($methodName, get_class($object));
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @throws ReflectionException
     *
     * @return ReflectionMethod
     */
    protected function getReflectionMethod($className, $methodName): ReflectionMethod
    {
        if (false === is_string($className)) {
            throw InvalidArgumentHelper::factory(1, 'string');
        }

        if (false === is_string($methodName)) {
            throw InvalidArgumentHelper::factory(2, 'string');
        }

        $reflection = new ReflectionClass($className);
        return $reflection->getMethod($methodName);
    }
}
