<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Filter\{
    AbstractDate,
    EndDate
};

/**
 * Class EndDateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class EndDateTest extends UnitTest
{
    /**
     * @var EndDate
     */
    protected $filter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->filter = new EndDate(DateTime::createFromFormat('Y-m-d', '2019-09-11'));
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->filter)->isInstanceOf(AbstractDate::class);
    }

    /**
     * @return void
     */
    public function testItHasAName(): void
    {
        verify($this->filter->getName())->string();
        verify($this->filter->getName())->notEmpty();
        verify($this->filter->getName())->equals('endDate');
    }

    /**
     * @return void
     */
    public function testItContainsAValue(): void
    {
        verify($this->filter->getValue())->string();
        verify($this->filter->getValue())->notEmpty();
        verify($this->filter->getValue())->equals('2019-09-11');
    }
}