<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Filter\AbstractArray;
use PayNL\Sdk\Filter\Filters;

/**
 * Class FiltersTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class FiltersTest extends UnitTest
{
    /**
     * @var AbstractArray
     */
    protected $filter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->filter = new Filters([ 'column1', 'column2' ]);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->filter)->isInstanceOf(AbstractArray::class);
    }

    /**
     * @return void
     */
    public function testItHasAName(): void
    {
        verify($this->filter->getName())->string();
        verify($this->filter->getName())->notEmpty();
        verify($this->filter->getName())->equals('filters');
    }

    /**
     * @return void
     */
    public function testItContainsAValue(): void
    {
        verify($this->filter->getValues())->array();
        verify($this->filter->getValues())->notEmpty();
        verify($this->filter->getValues())->equals([ 'column1', 'column2' ]);
    }
}
