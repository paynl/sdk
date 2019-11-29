<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\{
    ModelInterface,
    TransactionStatus
};
use Exception, JsonSerializable, UnitTester;
use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class StatusTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TransactionStatusTest extends UnitTest
{
    /**
     * @var TransactionStatus
     */
    protected $status;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->status = new TransactionStatus();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->status)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->status)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanGetAllowedStatus(): void
    {
        $output = $this->tester->invokeMethod($this->status, 'getAllowedStatus');
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
        expect($this->status->setCode(TransactionStatus::STATUS_PAID))->isInstanceOf(TransactionStatus::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenCodeIsNotAllowed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->status->setCode(1000);
    }

    /**
     * @depends testItCanSetACode
     *
     * @return void
     */
    public function testItCanGetACode(): void
    {
        $this->status->setCode(TransactionStatus::STATUS_PAID);

        verify($this->status->getCode())->int();
        verify($this->status->getCode())->notEmpty();
        verify($this->status->getCode())->equals(TransactionStatus::STATUS_PAID);
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->status->setName('Paid'))->isInstanceOf(TransactionStatus::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->status->setName('Paid');

        verify($this->status->getName())->string();
        verify($this->status->getName())->notEmpty();
        verify($this->status->getName())->equals('Paid');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetADate(): void
    {
        expect($this->status->setDate(DateTime::now()))->isInstanceOf(TransactionStatus::class);
    }

    /**
     * @depends testItCanSetADate
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetADate(): void
    {
        $this->status->setDate(DateTime::now());

        verify($this->status->getDate())->notEmpty();
        verify($this->status->getDate())->isInstanceOf(DateTime::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAReason(): void
    {
        expect($this->status->setReason('Lorem ipsum dolor sit amet'))->isInstanceOf(TransactionStatus::class);
    }

    /**
     * @depends testItCanSetAReason
     *
     * @return void
     */
    public function testItCanGetAReason(): void
    {
        $this->status->setReason('Lorem ipsum dolor sit amet');

        verify($this->status->getReason())->string();
        verify($this->status->getReason())->notEmpty();
        verify($this->status->getReason())->equals('Lorem ipsum dolor sit amet');
    }

    /**
     * @depends testItCanSetACode
     *
     * @return void
     */
    public function testItCanCheckStatusByString(): void
    {
        $this->status->setCode(TransactionStatus::STATUS_PAID);

        verify($this->status->is('STATUS_PAID'))->bool();
        verify($this->status->is('STATUS_PAID'))->true();
    }

    /**
     * @depends testItCanSetACode
     *
     * @return void
     */
    public function testItCanCheckStatusByInteger(): void
    {
        $this->status->setCode(TransactionStatus::STATUS_PAID);

        verify($this->status->is(TransactionStatus::STATUS_PAID))->bool();
        verify($this->status->is('STATUS_PAID'))->true();
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenStatusCheckGetsWrongArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->status->is([]);
    }
}
