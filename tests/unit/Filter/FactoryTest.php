<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\{
    Lib\FactoryTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Filter\Country,
    Filter\Factory,
    Service\Manager as ServiceManager
};
use UnitTester,
    Error
;

/**
 * Class FactoryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class FactoryTest extends UnitTest
{
    use FactoryTestTrait;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var ServiceManager
     */
    protected $serviceManagerMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->serviceManagerMock = $this->tester->getServiceManager();
        $this->factory = new Factory();
    }

    /**
     * @return void
     */
    public function testItCanCreateAFilter(): void
    {
        $filter = ($this->factory)($this->serviceManagerMock, Country::class);
        verify($filter)->isInstanceOf(Country::class);
    }

    /**
     * @return void
     */
    public function testItCanCreateAFilterWithASetValue(): void
    {
        $filter = ($this->factory)($this->serviceManagerMock, Country::class, ['value' => 'foo']);
        verify($filter)->isInstanceOf(Country::class);
        verify($filter->getValue())->string();
        verify($filter->getValue())->equals('0: foo');
    }

    /**
     * @return void
     */
    public function testItThrowAnExceptionWhenRequestedNameIsNotSupported(): void
    {
        $this->expectException(Error::class);
        ($this->factory)($this->serviceManagerMock, 'UnsupportedClassName');
    }
}
