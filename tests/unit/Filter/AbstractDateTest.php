<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Filter\{
    AbstractDate,
    FilterInterface
};
use UnitTester, Exception;

/**
 * Class AbstractDateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class AbstractDateTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractDate
     */
    protected $anonymousClassFromAbstract;

    /**
     * @throws Exception
     *
     * @return void
     */
    public function _before(): void
    {
        $date = DateTime::createFromFormat('Y-m-d', '2019-09-10');
        $this->anonymousClassFromAbstract = new class($date) extends AbstractDate
        {
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
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractDate::class);
    }

    /**
     * @return void
     */
    public function testItTriggersAnExceptionWhenGivenInputIsNotAValidString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new class('test') extends AbstractDate
        {
            public function getName(): string
            {
            }
        };
    }

    /**
     * @return void
     */
    public function testItTriggersAnExceptionWhenGivenInputIsNotAStringNorDatetimeObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new class(new \stdClass()) extends AbstractDate
        {
            public function getName(): string
            {
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
        verify($this->anonymousClassFromAbstract->getValue())->equals('2019-09-10');
    }

    /**
     *
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        $date = DateTime::createFromFormat('Y-m-d', '2019-07-01');
        verify($this->tester->getMethodAccessibility($this->anonymousClassFromAbstract, 'setValue'))->equals('protected');
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'setValue', [ $date ]);
        verify($this->anonymousClassFromAbstract->getValue())->equals($date);
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
