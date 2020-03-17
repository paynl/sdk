<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\FactoryTestTrait;
use Codeception\TestAsset\DummyTransformer;
use PayNL\Sdk\{Service\Manager as ServiceManager, Transformer\Factory, Transformer\TransformerInterface};
use UnitTester;

/**
 * Class FactoryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
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
    public function testItCanFilterATransformer(): void
    {
        $filter = ($this->factory)($this->serviceManagerMock, DummyTransformer::class);
        verify($filter)->isInstanceOf(TransformerInterface::class);
    }

}
