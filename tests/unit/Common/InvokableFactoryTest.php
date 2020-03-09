<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

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

    }

    /**
     * @return void
     */
    public function testItCanMakeAnInstanceWithOptions(): void
    {

    }
}
