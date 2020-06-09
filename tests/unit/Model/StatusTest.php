<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Common\DateTime,
    Model\Status,
    Exception\InvalidArgumentException
};
use Mockery;

/**
 * Class StatusTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class StatusTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Status
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Status();
    }

    /**
     * @return void
     */
    public function testItCanSetCode(): void
    {
        $this->tester->assertObjectHasMethod('setCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCode', $this->model);

        $status = $this->model->setCode('100');
        verify($status)->object();
        verify($status)->same($this->model);

        $status = $this->model->setCode(200);
        verify($status)->object();
        verify($status)->same($this->model);
    }

    /**
     * @depends testItCanSetCode
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenCodeIsNotCorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->model->setCode([]);
    }

    /**
     * @depends testItCanSetCode
     *
     * @return void
     */
    public function testItCanGetCode(): void
    {
        $this->tester->assertObjectHasMethod('getCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCode', $this->model);

        $code = $this->model->getCode();
        verify($code)->string();
        verify($code)->isEmpty();
        verify($code)->equals('');

        $this->model->setCode('100');
        $code = $this->model->getCode();
        verify($code)->string();
        verify($code)->notEmpty();
        verify($code)->equals('100');

        $this->model->setCode(200);
        $code = $this->model->getCode();
        verify($code)->string();
        verify($code)->notEmpty();
        verify($code)->equals('200');
    }

    /**
     * @return void
     */
    public function testItCanSetName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        $status = $this->model->setName('foo');
        verify($status)->object();
        verify($status)->same($this->model);
    }

    /**
     * @depends testItCanSetName
     *
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $name = $this->model->getName();
        verify($name)->string();
        verify($name)->isEmpty();

        $this->model->setName('foo');
        $name = $this->model->getName();
        verify($name)->string();
        verify($name)->notEmpty();
        verify($name)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetDate(): void
    {
        $this->tester->assertObjectHasMethod('setDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDate', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $status = $this->model->setDate($dateTimeMock);
        verify($status)->object();
        verify($status)->same($this->model);
    }

    /**
     * @depends testItCanSetDate
     *
     * @return void
     */
    public function testItCanGetDate(): void
    {
        $this->tester->assertObjectHasMethod('getDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDate', $this->model);

        $now = $this->model->getDate();
        verify($now)->isInstanceOf(DateTime::class);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $this->model->setDate($dateTimeMock);
        $date = $this->model->getDate();
        verify($date)->notEmpty();
        verify($date)->isInstanceOf(DateTime::class);
        verify($date)->same($dateTimeMock);
        verify($date)->notSame($now);
    }

    /**
     * @return void
     */
    public function testItCanSetReason(): void
    {
        $this->tester->assertObjectHasMethod('setReason', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReason', $this->model);

        $status = $this->model->setReason('Lorem ipsum dolor sit amet');
        verify($status)->object();
        verify($status)->same($this->model);
    }

    /**
     * @depends testItCanSetReason
     *
     * @return void
     */
    public function testItCanGetReason(): void
    {
        $this->tester->assertObjectHasMethod('getReason', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReason', $this->model);

        $reason = $this->model->getReason();
        verify($reason)->string();
        verify($reason)->isEmpty();

        $this->model->setReason('Lorem ipsum dolor sit amet');
        $reason = $this->model->getReason();
        verify($reason)->string();
        verify($reason)->notEmpty();
        verify($reason)->equals('Lorem ipsum dolor sit amet');
    }
}
