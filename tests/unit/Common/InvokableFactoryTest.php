<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\TestAsset\Dummy;
use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Common\FactoryInterface;
use PayNL\Sdk\Common\InvokableFactory;
use UnitTester;

class InvokableFactoryTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var FactoryInterface
     */
    protected $invokableFactory;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->invokableFactory = new InvokableFactory();
    }

    /**
     * @return void
     */
    public function testItIsAFactory(): void
    {
        verify($this->invokableFactory)->isInstanceOf(FactoryInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsACallable(): void
    {
        $this->tester->assertClassHasMethod('__invoke', InvokableFactory::class);
        verify($this->invokableFactory)->callable();
    }

    /**
     * @return void
     */
    public function testItCanMakeAnInstance(): void
    {
        $dummy = ($this->invokableFactory)($this->tester->getServiceManager(), Dummy::class);
        verify($dummy)->isInstanceOf(Dummy::class);
        verify($dummy->getOptions())->isEmpty();
    }

    /**
     * @return void
     */
    public function testItCanMakeAnInstanceWithOptions(): void
    {
        $dummy = ($this->invokableFactory)($this->tester->getServiceManager(), Dummy::class, ['foo' => 'bar']);
        verify($dummy)->isInstanceOf(Dummy::class);
        verify($dummy->getOptions())->notEmpty();
        verify($dummy->getOptions())->hasKey('foo');
        verify($dummy->getOptions()['foo'])->equals('bar');
    }
}
