<?php

declare(strict_types=1);

namespace Codeception\Lib;

use PayNL\Sdk\Model\ModelInterface;
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
    protected $shouldItBeJsonSerializable = false;

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
     * @return $this
     */
    protected function markAsJsonSerializeable(): self
    {
        $this->shouldItBeJsonSerializable = true;
        return $this;
    }

    /**
     * @return void
     */
    public function testItShouldBeJsonSerializable(): void
    {
        if (true === $this->shouldItBeJsonSerializable) {
            $this->tester->assertObjectIsJsonSerializable($this->model);
        } else {
            $this->tester->assertObjectIsNotJsonSerializable($this->model);
        }
    }
}
