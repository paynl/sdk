<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Filter\{
    AbstractScalar,
    ServiceId
};

/**
 * Class ServiceIdTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class ServiceIdTest extends UnitTest
{
    /**
     * @var ServiceId
     */
    protected $filter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->filter = new ServiceId('SL-1234-4567');
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
        verify($this->filter->getName())->equals('serviceId');
    }

    /**
     * @return void
     */
    public function testItContainsAValue(): void
    {
        verify($this->filter->getValue())->string();
        verify($this->filter->getValue())->notEmpty();
        verify($this->filter->getValue())->equals('SL-1234-4567');
    }
}
