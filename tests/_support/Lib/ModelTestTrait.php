<?php

declare(strict_types=1);

namespace Codeception\Lib;

use PayNL\Sdk\Model\ModelInterface;
use PHPUnit\Framework\Assert;
use UnitTester;

/**
 * Class ModelTestTrait
 *
 * @package Codeception\Lib
 */
trait ModelTestTrait
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var bool
     */
    protected $shouldItBeJsonSerializable;

    /**
     * @var ModelInterface
     */
    protected $model;

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->model)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldBeJsonSerializable(): void
    {
        if (null === $this->shouldItBeJsonSerializable) {
            Assert::fail(
                sprintf(
                    'Model test "%s" should set if it should or shouldn\'t be JsonSerializable',
                    __CLASS__
                )
            );
        }

        if (true === $this->shouldItBeJsonSerializable) {
            $this->tester->assertObjectIsJsonSerializable($this->model);
        } else {
            $this->tester->assertObjectIsNotJsonSerializable($this->model);
        }
    }
}
