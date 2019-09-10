<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Filter\AbstractScalar;
use PayNL\Sdk\Filter\FilterInterface;
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
     *
     * @return void
     */
    public function _before()
    {
        $this->anonymousClassFromAbstract = new class(1) extends AbstractScalar {
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
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractScalar::class);

        $this->expectException(InvalidArgumentException::class);
        new class(new \stdClass()) extends AbstractScalar {
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
        verify($this->anonymousClassFromAbstract->getValue())->notEmpty();
        verify($this->anonymousClassFromAbstract->getValue())->string();
        verify($this->anonymousClassFromAbstract->getValue())->equals('1');
    }

    /**
     *
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        verify($this->tester->getMethodAccessibility($this->anonymousClassFromAbstract, 'setValue'))->equals('protected');
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'setValue', [ 'newValue' ]);
        verify($this->anonymousClassFromAbstract->getValue())->equals('newValue');
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
