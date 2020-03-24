<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Progress
};
use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class ProgressTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ProgressTest extends UnitTest
{
    /**
     * @var Progress
     */
    protected $progress;

    public function _before(): void
    {
        $this->progress = new Progress();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->progress)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->progress)->isInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItHasJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->progress), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAPercentage(): void
    {
        expect($this->progress->setPercentage(10))->isInstanceOf(Progress::class);
    }

    /**
     * @depends testItCanSetAPercentage
     *
     * @return void
     */
    public function testItCanGetAPercentage(): void
    {
        $this->progress->setPercentage(10);

        verify($this->progress->getPercentage())->int();
        verify($this->progress->getPercentage())->notEmpty();
        verify($this->progress->getPercentage())->equals(10);
    }

    /**
     * @return void
     */
    public function testItCanSetSecondsPast(): void
    {
        expect($this->progress->setSecondsPassed(2))->isInstanceOf(Progress::class);
    }

    /**
     * @depends testItCanSetSecondsPast
     *
     * @return void
     */
    public function testItCanGetSecondsPast(): void
    {
        $this->progress->setSecondsPassed(2);

        verify($this->progress->getSecondsPassed())->int();
        verify($this->progress->getSecondsPassed())->notEmpty();
        verify($this->progress->getSecondsPassed())->equals(2);
    }

    /**
     * @return void
     */
    public function testItCanSetAPercentagePerSecond(): void
    {
        expect($this->progress->setPercentagePerSecond(100/120))->isInstanceOf(Progress::class);
    }

    /**
     * @depends testItCanSetAPercentagePerSecond
     *
     * @return void
     */
    public function testItCanGetAPercentagePerSecond(): void
    {
        $this->progress->setPercentagePerSecond(100/120);

        verify($this->progress->getPercentagePerSecond())->float();
        verify($this->progress->getPercentagePerSecond())->notEmpty();
        verify($this->progress->getPercentagePerSecond())->equals(100/120);
    }
}
