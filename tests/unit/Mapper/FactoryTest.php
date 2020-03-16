<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Mapper;

use Codeception\{
    Lib\FactoryTestTrait,
    Test\Unit as UnitTest,
    TestAsset\SimpleDummyMapper
};
use PayNL\Sdk\{Exception\ServiceNotCreatedException,
    Mapper\AbstractMapper,
    Mapper\Factory,
    Service\Manager as ServiceManager};
use UnitTester;

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
    public function testItCanCreateAMapper(): void
    {
        $mapper = ($this->factory)($this->serviceManagerMock, SimpleDummyMapper::class);
        verify($mapper)->isInstanceOf(AbstractMapper::class);

        $mapConfiguration = $mapper->getMapping();
        verify($mapConfiguration)->array();
        verify($mapConfiguration)->notEmpty();
        verify($mapConfiguration)->hasKey('InvokableObject');
        verify($mapConfiguration)->contains('Dummy');
    }

    /**
     * @return void
     */
    public function testItThrowAnExceptionWhenMapperHasNoConfiguration(): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        ($this->factory)($this->serviceManagerMock, 'UnsupportedClassName');
    }
}
