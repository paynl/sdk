<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Progress;

/**
 * Class ProgressTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ProgressTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Progress
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Progress();
    }

    /**
     * @return void
     */
    public function testItCanSetAPercentage(): void
    {
        $this->tester->assertObjectHasMethod('setPercentage', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPercentage', $this->model);

        expect($this->model->setPercentage(10))->isInstanceOf(Progress::class);
    }

    /**
     * @depends testItCanSetAPercentage
     *
     * @return void
     */
    public function testItCanGetAPercentage(): void
    {
        $this->tester->assertObjectHasMethod('getPercentage', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPercentage', $this->model);

        $this->model->setPercentage(10);

        verify($this->model->getPercentage())->int();
        verify($this->model->getPercentage())->notEmpty();
        verify($this->model->getPercentage())->equals(10);
    }

    /**
     * @return void
     */
    public function testItCanSetSecondsPast(): void
    {
        $this->tester->assertObjectHasMethod('setSecondsPassed', $this->model);
        $this->tester->assertObjectMethodIsPublic('setSecondsPassed', $this->model);

        expect($this->model->setSecondsPassed(2))->isInstanceOf(Progress::class);
    }

    /**
     * @depends testItCanSetSecondsPast
     *
     * @return void
     */
    public function testItCanGetSecondsPast(): void
    {
        $this->tester->assertObjectHasMethod('getSecondsPassed', $this->model);
        $this->tester->assertObjectMethodIsPublic('getSecondsPassed', $this->model);

        $this->model->setSecondsPassed(2);

        verify($this->model->getSecondsPassed())->int();
        verify($this->model->getSecondsPassed())->notEmpty();
        verify($this->model->getSecondsPassed())->equals(2);
    }

    /**
     * @return void
     */
    public function testItCanSetAPercentagePerSecond(): void
    {
        $this->tester->assertObjectHasMethod('setPercentagePerSecond', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPercentagePerSecond', $this->model);

        expect($this->model->setPercentagePerSecond(100/120))->isInstanceOf(Progress::class);
    }

    /**
     * @depends testItCanSetAPercentagePerSecond
     *
     * @return void
     */
    public function testItCanGetAPercentagePerSecond(): void
    {
        $this->tester->assertObjectHasMethod('getPercentagePerSecond', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPercentagePerSecond', $this->model);

        $this->model->setPercentagePerSecond(100/120);

        verify($this->model->getPercentagePerSecond())->float();
        verify($this->model->getPercentagePerSecond())->notEmpty();
        verify($this->model->getPercentagePerSecond())->equals(100/120);
    }
}
