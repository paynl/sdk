<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Filter\{
    AbstractScalar,
    Staffels
};

/**
 * Class StaffelsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class StaffelsTest extends UnitTest
{
    /**
     * @var Staffels
     */
    protected $filter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->filter = new Staffels(1);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->filter)->isInstanceOf(AbstractScalar::class);
    }

    /**
     * @return void
     */
    public function testItHasAName(): void
    {
        verify($this->filter->getName())->string();
        verify($this->filter->getName())->notEmpty();
        verify($this->filter->getName())->equals('staffels');
    }

    /**
     * @return void
     */
    public function testItContainsAValue(): void
    {
        verify($this->filter->getValue())->string();
        verify($this->filter->getValue())->notEmpty();
        verify($this->filter->getValue())->equals('1');
    }
}
