<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Common\DateTime,
    Model\TransactionStatus,
    Exception\InvalidArgumentException
};

/**
 * Class StatusTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TransactionStatusTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var TransactionStatus
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new TransactionStatus();
    }

    /**
     * @return void
     */
    public function testItCanGetAllowedStatus(): void
    {
        $output = $this->tester->invokeMethod($this->model, 'getAllowedStatus');
        verify($output)->array();
        verify($output)->notEmpty();
        verify($output)->containsOnly('int');
    }

    /**
     * @depends testItCanGetAllowedStatus
     *
     * @return void
     */
    public function testItCanSetACode(): void
    {
        $this->tester->assertObjectHasMethod('setCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCode', $this->model);

        expect($this->model->setCode(TransactionStatus::STATUS_PAID))->isInstanceOf(TransactionStatus::class);
    }

    /**
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenCodeIsNotAllowed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->model->setCode(1000);
    }

    /**
     * @depends testItCanSetACode
     *
     * @return void
     */
    public function testItCanGetACode(): void
    {
        $this->tester->assertObjectHasMethod('getCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCode', $this->model);

        $this->model->setCode(TransactionStatus::STATUS_PAID);

        verify($this->model->getCode())->int();
        verify($this->model->getCode())->notEmpty();
        verify($this->model->getCode())->equals(TransactionStatus::STATUS_PAID);
    }

    /**
     * @depends testItCanSetACode
     * @depends testItCanGetACode
     *
     * @return void
     */
    public function testItConvertsCodeToString(): void
    {
        $this->model->setCode('100');
        verify($this->model->getCode())->int();
        verify($this->model->getCode())->equals(100);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenGivenCodeIsNotAStringNorAnInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->model->setCode([]);
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('Paid'))->isInstanceOf(TransactionStatus::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $this->model->setName('Paid');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('Paid');
    }

    /**
     * @return void
     */
    public function testItCanSetADate(): void
    {
        $this->tester->assertObjectHasMethod('setDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDate', $this->model);

        expect($this->model->setDate(DateTime::now()))->isInstanceOf(TransactionStatus::class);
    }

    /**
     * @depends testItCanSetADate
     *
     * @return void
     */
    public function testItCanGetADate(): void
    {
        $this->tester->assertObjectHasMethod('getDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDate', $this->model);

        $this->model->setDate(DateTime::now());

        verify($this->model->getDate())->notEmpty();
        verify($this->model->getDate())->isInstanceOf(DateTime::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAReason(): void
    {
        $this->tester->assertObjectHasMethod('setReason', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReason', $this->model);

        expect($this->model->setReason('Lorem ipsum dolor sit amet'))->isInstanceOf(TransactionStatus::class);
    }

    /**
     * @depends testItCanSetAReason
     *
     * @return void
     */
    public function testItCanGetAReason(): void
    {
        $this->tester->assertObjectHasMethod('getReason', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReason', $this->model);

        $this->model->setReason('Lorem ipsum dolor sit amet');

        verify($this->model->getReason())->string();
        verify($this->model->getReason())->notEmpty();
        verify($this->model->getReason())->equals('Lorem ipsum dolor sit amet');
    }

    /**
     * @depends testItCanSetACode
     *
     * @return void
     */
    public function testItCanCheckStatusByString(): void
    {
        $this->tester->assertObjectHasMethod('isStatus', $this->model);
        $this->tester->assertObjectMethodIsPublic('isStatus', $this->model);

        $this->model->setCode(TransactionStatus::STATUS_PAID);

        verify($this->model->isStatus('STATUS_PAID'))->bool();
        verify($this->model->isStatus('STATUS_PAID'))->true();
    }

    /**
     * @depends testItCanSetACode
     *
     * @return void
     */
    public function testItCanCheckStatusByInteger(): void
    {
        $this->tester->assertObjectHasMethod('isStatus', $this->model);
        $this->tester->assertObjectMethodIsPublic('isStatus', $this->model);

        $this->model->setCode(TransactionStatus::STATUS_PAID);

        verify($this->model->isStatus(TransactionStatus::STATUS_PAID))->bool();
        verify($this->model->isStatus('STATUS_PAID'))->true();
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenStatusCheckGetsWrongArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->model->isStatus([]);
    }
}
