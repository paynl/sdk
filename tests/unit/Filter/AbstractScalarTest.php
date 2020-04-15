<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Filter\AbstractScalar,
    Filter\FilterInterface,
    Exception\InvalidArgumentException
};
use UnitTester;

/**
 * Class AbstractScalarTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class AbstractScalarTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractScalar
     */
    protected $anonymousClassFromAbstract;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class('foo') extends AbstractScalar {
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
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractScalar::class);
    }

    /**
     * @return void
     */
    public function testItCanGetValue(): void
    {
        $value = $this->anonymousClassFromAbstract->getValue();
        verify($value)->string();
        verify($value)->notEmpty();
        verify($value)->equals('foo');
    }

    /**
     * @depends testItCanGetValue
     *
     * @return void
     */
    public function testItCanSetValue(): void
    {
        verify($this->anonymousClassFromAbstract->setValue('bar'))->isInstanceOf(AbstractScalar::class);

        $value = $this->anonymousClassFromAbstract->getValue();
        verify($value)->string();
        verify($value)->equals('bar');

        $this->anonymousClassFromAbstract->setValue(true);
        $value = $this->anonymousClassFromAbstract->getValue();
        verify($value)->string();
        verify($value)->equals('1');

        $this->anonymousClassFromAbstract->setValue(1);
        $value = $this->anonymousClassFromAbstract->getValue();
        verify($value)->string();
        verify($value)->equals('1');

        $this->anonymousClassFromAbstract->setValue(1.99);
        $value = $this->anonymousClassFromAbstract->getValue();
        verify($value)->string();
        verify($value)->equals('1.99');
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
        verify($filterString)->equals('anonymousClassFilter=foo');
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
        new class(new InvalidArgumentException()) extends AbstractScalar
        {
            public function getName(): string
            {
                return '';
            }
        };
    }
}
