<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Filter\AbstractArray;
use PayNL\Sdk\Filter\FilterInterface;
use UnitTester;

/**
 * Class AbstractScalarTest
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
     *
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class([ 1, 2 ]) extends AbstractArray {
            public function getName(): string
            {
                return 'anonymousClassFilter';
            }
        };
    }

    /**
     *
     * @return void
     */
    public function testInstanceOfFilterInterface(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(FilterInterface::class);
    }

    /**
     *
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractArray::class);

        $this->expectException(\TypeError::class);
        new class(new \stdClass()) extends AbstractArray {
            public function getName(): string
            {
                return 'ThisBreaksFilter';
            }
        };
    }

    /**
     *
     * @return void
     */
    public function testItContainsAValue(): void
    {
        verify($this->anonymousClassFromAbstract->getValues())->notEmpty();
        verify($this->anonymousClassFromAbstract->getValues())->array();
        verify($this->anonymousClassFromAbstract->getValues())->equals([ 1, 2 ]);
    }

    /**
     *
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        verify($this->tester->getMethodAccessibility($this->anonymousClassFromAbstract, 'setValues'))->equals('protected');
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'setValues', [ [ 3, 4 ] ]);
        verify($this->anonymousClassFromAbstract->getValues())->equals([ 3, 4 ]);
    }

    /**
     *
     * @return void
     */
    public function testItCanBeConvertedToAString(): void
    {
        verify((string)$this->anonymousClassFromAbstract)->string();
    }
}
