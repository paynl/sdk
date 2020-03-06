<?php

declare(strict_types=1);

namespace Codeception\Lib;

use PayNL\Sdk\Common\FactoryInterface;

/**
 * Trait FactoryTestTrait
 *
 * @package Codeception\Lib
 */
trait FactoryTestTrait
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @return void
     */
    public function testItIsAFactory(): void
    {
        verify($this->factory)->isInstanceOf(FactoryInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsCallable(): void
    {
        verify(method_exists($this->factory, '__invoke'))->true();
        verify($this->factory)->callable();
    }
}
