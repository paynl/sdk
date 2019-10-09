<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Statistics
};
use JsonSerializable;

/**
 * Class StatisticsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class StatisticsTest extends UnitTest
{
    /**
     * @var Statistics
     */
    protected $statistics;

    public function _before(): void
    {
        $this->statistics = new Statistics();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->statistics)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->statistics)->isInstanceOf(JsonSerializable::class);

        verify($this->statistics->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAPromoterId(): void
    {
        expect($this->statistics->setPromoterId('680f74f9-d9e2-11e9-96ef-90b11c281a75'))->isInstanceOf(Statistics::class);
    }

    /**
     * @depends testItCanSetAPromoterId
     *
     * @return void
     */
    public function testItCanGetAPromoterId(): void
    {
        $this->statistics->setPromoterId('680f74f9-d9e2-11e9-96ef-90b11c281a75');

        verify($this->statistics->getPromoterId())->string();
        verify($this->statistics->getPromoterId())->notEmpty();
        verify($this->statistics->getPromoterId())->equals('680f74f9-d9e2-11e9-96ef-90b11c281a75');
    }

    /**
     * @return void
     */
    public function testItCanSetInfo(): void
    {
        expect($this->statistics->setInfo('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
            ->isInstanceOf(Statistics::class)
        ;
    }

    /**
     * @depends testItCanSetInfo
     *
     * @return void
     */
    public function testItCanGetInfo(): void
    {
        $this->statistics->setInfo('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->statistics->getInfo())->string();
        verify($this->statistics->getInfo())->notEmpty();
        verify($this->statistics->getInfo())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra1(): void
    {
        expect($this->statistics->setExtra1('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
            ->isInstanceOf(Statistics::class)
        ;
    }

    /**
     * @depends testItCanSetExtra1
     *
     * @return void
     */
    public function testItCanGetExtra1(): void
    {
        $this->statistics->setExtra1('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->statistics->getExtra1())->string();
        verify($this->statistics->getExtra1())->notEmpty();
        verify($this->statistics->getExtra1())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra2(): void
    {
        expect($this->statistics->setExtra2('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
            ->isInstanceOf(Statistics::class)
        ;
    }

    /**
     * @depends testItCanSetExtra2
     *
     * @return void
     */
    public function testItCanGetExtra2(): void
    {
        $this->statistics->setExtra2('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->statistics->getExtra2())->string();
        verify($this->statistics->getExtra2())->notEmpty();
        verify($this->statistics->getExtra2())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra3(): void
    {
        expect($this->statistics->setExtra3('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
            ->isInstanceOf(Statistics::class)
        ;
    }

    /**
     * @depends testItCanSetExtra3
     *
     * @return void
     */
    public function testItCanGetExtra3(): void
    {
        $this->statistics->setExtra3('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->statistics->getExtra3())->string();
        verify($this->statistics->getExtra3())->notEmpty();
        verify($this->statistics->getExtra3())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @return void
     */
    public function testItCanSetTransferData(): void
    {
        expect($this->statistics->setTransferData([
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Donec commodo neque id felis semper, vitae.',
        ]))->isInstanceOf(Statistics::class);
    }

    /**
     * @depends testItCanSetTransferData
     *
     * @return void
     */
    public function testItCanGetTransferData(): void
    {
        $this->statistics->setTransferData([
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Donec commodo neque id felis semper, vitae.',
        ]);

        verify($this->statistics->getTransferData())->array();
        verify($this->statistics->getTransferData())->notEmpty();
        verify($this->statistics->getTransferData())->count(2);
    }
}
