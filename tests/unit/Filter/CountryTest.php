<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Filter\AbstractArray;
use PayNL\Sdk\Filter\Country;
use UnitTester;

/**
 * Class CountryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class CountryTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Country
     */
    protected $countryFilter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->countryFilter = new Country();
    }

    /**
     * @return void
     */
    public function testItIsAnArrayFilter(): void
    {
        verify($this->countryFilter)->isInstanceOf(AbstractArray::class);
    }

    /**
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->countryFilter);

        $name = $this->countryFilter->getName();
        verify($name)->string();
        verify($name)->notEmpty();
        verify($name)->equals('country');
    }
}
