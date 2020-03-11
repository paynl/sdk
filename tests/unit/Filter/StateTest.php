<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Filter\AbstractScalar;
use PayNL\Sdk\Filter\State;
use UnitTester;

/**
 * Class StateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class StateTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var State
     */
    protected $stateFilter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->stateFilter = new State();
    }

    /**
     * @return void
     */
    public function testItIsAScalarFilter(): void
    {
        verify($this->stateFilter)->isInstanceOf(AbstractScalar::class);
    }

    /**
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->stateFilter);

        $name = $this->stateFilter->getName();
        verify($name)->string();
        verify($name)->notEmpty();
        verify($name)->equals('state');
    }
}
