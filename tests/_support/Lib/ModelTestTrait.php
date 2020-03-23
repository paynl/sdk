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
    public function testItIsJsonSerializable(): void
    {
        $this->tester->assertObjectIsJsonSerializable($this->model);
    }
}
