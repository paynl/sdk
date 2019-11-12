<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\{
    ModelInterface,
    Status
};
use Exception, JsonSerializable;

/**
 * Class StatusTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class StatusTest extends UnitTest
{
    /**
     * @var Status
     */
    protected $status;

    public function _before(): void
    {
        $this->status = new Status();
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
    public function testItCanSetACode(): void
    {
        expect($this->status->setCode('Paid'))->isInstanceOf(Status::class);
    }

    /**
     * @depends testItCanSetACode
     *
     * @return void
     */
    public function testItCanGetACode(): void
    {
        $this->status->setCode('Paid');

        verify($this->status->getCode())->string();
        verify($this->status->getCode())->notEmpty();
        verify($this->status->getCode())->equals('Paid');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->status->setName('Paid'))->isInstanceOf(Status::class);
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
        expect($this->status->setDate(DateTime::now()))->isInstanceOf(Status::class);
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
        expect($this->status->setReason('Lorem ipsum dolor sit amet'))->isInstanceOf(Status::class);
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
}
