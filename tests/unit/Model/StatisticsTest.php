<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Lib\ModelTestTrait;
use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Statistics;

/**
 * Class StatisticsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class StatisticsTest extends UnitTest
{
    use ModelTestTrait;

    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Statistics();
    }

    /**
     * @return void
     */
    public function testItCanSetAnObject(): void
    {
        verify($this->model->setObject('12345'))->isInstanceOf(Statistics::class);
    }

    /**
     * @return void
     */
    public function testItCanSetInfo(): void
    {
        expect($this->model->setInfo('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
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
        $this->model->setInfo('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->model->getInfo())->string();
        verify($this->model->getInfo())->notEmpty();
        verify($this->model->getInfo())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @depends testItCanSetAnObject
     *
     * @return void
     */
    public function testItCanGetAnObject(): void
    {
        $this->model->setObject('12345');
        verify($this->model->getObject())->string();
        verify($this->model->getObject())->notEmpty();
        verify($this->model->getObject())->equals('12345');
    }

    /**
     * @return void
     */
    public function testItCanSetATool(): void
    {
        verify($this->model->setTool('12345'))->isInstanceOf(Statistics::class);
    }

    /**
     * @depends testItCanSetATool
     *
     * @return void
     */
    public function testItCanGetATool(): void
    {
        $this->model->setTool('12345');
        verify($this->model->getTool())->string();
        verify($this->model->getTool())->notEmpty();
        verify($this->model->getTool())->equals('12345');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra1(): void
    {
        verify($this->model->setExtra1('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
            ->isInstanceOf(Statistics::class);
    }

    /**
     * @depends testItCanSetExtra1
     *
     * @return void
     */
    public function testItCanGetExtra1(): void
    {
        $this->model->setExtra1('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->model->getExtra1())->string();
        verify($this->model->getExtra1())->notEmpty();
        verify($this->model->getExtra1())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra2(): void
    {
        expect($this->model->setExtra2('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
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
        $this->model->setExtra2('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->model->getExtra2())->string();
        verify($this->model->getExtra2())->notEmpty();
        verify($this->model->getExtra2())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra3(): void
    {
        expect($this->model->setExtra3('Lorem ipsum dolor sit amet, consectetur adipiscing elit'))
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
        $this->model->setExtra3('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->model->getExtra3())->string();
        verify($this->model->getExtra3())->notEmpty();
        verify($this->model->getExtra3())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }
}
