<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\FactoryTestTrait;
use PayNL\Sdk\{
    Service\Manager as ServiceManager,
    Validator\Factory,
    Validator\InputType
};
use UnitTester;

/**
 * Class FactoryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
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
    public function testItCanCreateAValidator(): void
    {
        $filter = ($this->factory)($this->serviceManagerMock, InputType::class);
        verify($filter)->isInstanceOf(InputType::class);
    }

}
