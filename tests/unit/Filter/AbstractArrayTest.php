<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Filter\FilterInterface,
    Filter\AbstractArray,
    Exception\InvalidArgumentException
};
use UnitTester;

/**
 * Class AbstractArrayTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class AbstractArrayTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractArray
     */
    protected $anonymousClassFromAbstract;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class([ 1, 2, ['test' => 1] ]) extends AbstractArray {
            public function getName(): string
            {
                return 'anonymousClassFilter';
            }
        };
    }

    /**
     * @return void
     */
    public function testInstanceOfFilterInterface(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(FilterInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractArray::class);
    }

    /**
     * @return void
     */
    public function testItCanGetValues(): void
    {
        $this->tester->assertObjectHasMethod('getValues', $this->anonymousClassFromAbstract);
        $values = $this->anonymousClassFromAbstract->getValues();
        verify($values)->array();
        verify($values)->notEmpty();
        verify($values)->equals([ 1, 2, ['test' => 1] ]);
    }

    /**
     * @depends testItCanGetValues
     *
     * @return void
     */
    public function testItCanGetValue(): void
    {
        $value = $this->anonymousClassFromAbstract->getValue();
        verify($value)->string();
        verify($value)->notEmpty();
        verify($value)->equals('0: 1, 1: 2, test: 1');
    }

    /**
     * @depends testItCanGetValues
     *
     * @return void
     */
    public function testItCanSetValues(): void
    {
        $this->tester->assertObjectHasMethod('setValues', $this->anonymousClassFromAbstract);
        verify($this->anonymousClassFromAbstract->setValues(['foo', 'bar']))->isInstanceOf(AbstractArray::class);

        $values = $this->anonymousClassFromAbstract->getValues();
        verify($values)->array();
        verify($values)->count(2);
        verify($values)->contains('foo');
        verify($values)->contains('bar');
        verify($values)->notContains(1);
        verify($values)->notContains(2);
    }

    /**
     * @depends testItCanSetValues
     * @depends testItCanGetValues
     *
     * @return void
     */
    public function testItCanSetValue(): void
    {
        verify($this->anonymousClassFromAbstract->setValue('foo'))->isInstanceOf(AbstractArray::class);

        $values = $this->anonymousClassFromAbstract->getValues();
        verify($values)->array();
        verify($values)->count(1);
        verify($values)->contains('foo');

        verify($this->anonymousClassFromAbstract->setValue(['bar', 'baz']))->isInstanceOf(AbstractArray::class);
        $values = $this->anonymousClassFromAbstract->getValues();
        verify($values)->array();
        verify($values)->count(2);
        verify($values)->contains('bar');
        verify($values)->contains('baz');
    }

    /**
     * @return void
     */
    public function testSetValueThrowsExceptionWithInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->anonymousClassFromAbstract->setValue(new InvalidArgumentException());
    }

    /**
     * @return void
     */
    public function testItCanBeConvertedToAString(): void
    {
        $filterString = (string)$this->anonymousClassFromAbstract;
        verify($filterString)->string();
        verify($filterString)->equals('anonymousClassFilter[0]=1&anonymousClassFilter[1]=2&anonymousClassFilter[2][test]=1');
    }

    /**
     * @depends testItCanConstruct
     * @depends testItCanSetValue
     *
     * @return void
     */
    public function testConstructionThrowsExceptionWhenInvalidValueGiven(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new class(new InvalidArgumentException()) extends AbstractArray
        {
            public function getName(): string
            {
                return '';
            }
        };
    }
}
