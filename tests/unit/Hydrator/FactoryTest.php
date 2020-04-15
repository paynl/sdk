<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\{
    Lib\FactoryTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Exception\ServiceNotFoundException,
    Hydrator\AbstractHydrator,
    Hydrator\Entity,
    Hydrator\Factory,
    Service\Manager as ServiceManager
};
use UnitTester, Error;

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
    public function testItCanCreateAHydrator(): void
    {
        $filter = ($this->factory)($this->serviceManagerMock, Entity::class);
        verify($filter)->isInstanceOf(AbstractHydrator::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenNoModelManagerIsPresent(): void
    {
        $this->expectException(ServiceNotFoundException::class);
        $simpleManager = $this->tester->grabMockService('simpleManager');
        ($this->factory)($simpleManager, Entity::class);
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
