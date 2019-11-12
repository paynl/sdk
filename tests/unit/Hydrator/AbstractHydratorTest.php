<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\AbstractHydrator;
use UnitTester, stdClass;
use Zend\Hydrator\ClassMethods;

/**
 * Class AbstractHydratorTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class AbstractHydratorTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractHydrator
     */
    protected $anonymousClassFromAbstract;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class() extends AbstractHydrator {};
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractHydrator::class);
    }

    /**
     * @return void
     */
    public function testItIsAnInstanceOfClassMethodsHydrator(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(ClassMethods::class);
    }

    /**
     * @return void
     */
    public function testItSetsConstructorParameterUnderscoreSeparatedKeysAlwaysOnFalse(): void
    {
        $cls = new class(true) extends AbstractHydrator {};
        verify($cls->getUnderscoreSeparatedKeys())->equals(false);
    }

    /**
     * @return void
     */
    public function testItSetsConstructorParameterMethodExistsCheckAlwaysOnTrue(): void
    {
        $cls = new class(false, false) extends AbstractHydrator {};
        verify($cls->getMethodExistsCheck())->equals(true);
    }

    /**
     * @return void
     */
    public function testIfMethodValidateGivenObjectIsProtected(): void
    {
        verify($this->tester->getMethodAccessibility($this->anonymousClassFromAbstract, 'validateGivenObject'))->equals('protected');
    }

    /**
     * @return void
     */
    public function testItCanValidateAnObjectToBeAnInstanceOfTheDesiredClass(): void
    {
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'validateGivenObject', [ new stdClass(), stdClass::class ]);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenTheObjectIsAWrongInstance(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'validateGivenObject', [ new stdClass(), 'Test' ]);
    }
}
