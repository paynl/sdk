<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
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
        $this->tester->assertObjectHasMethod('setObject', $this->model);
        $this->tester->assertObjectMethodIsPublic('setObject', $this->model);

        verify($this->model->setObject('12345'))->isInstanceOf(Statistics::class);
    }

    /**
     * @return void
     */
    public function testItCanSetInfo(): void
    {
        $this->tester->assertObjectHasMethod('setInfo', $this->model);
        $this->tester->assertObjectMethodIsPublic('setInfo', $this->model);

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
        $this->tester->assertObjectHasMethod('getInfo', $this->model);
        $this->tester->assertObjectMethodIsPublic('getInfo', $this->model);

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
        $this->tester->assertObjectHasMethod('getObject', $this->model);
        $this->tester->assertObjectMethodIsPublic('getObject', $this->model);

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
        $this->tester->assertObjectHasMethod('setTool', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTool', $this->model);

        verify($this->model->setTool('12345'))->isInstanceOf(Statistics::class);
    }

    /**
     * @depends testItCanSetATool
     *
     * @return void
     */
    public function testItCanGetATool(): void
    {
        $this->tester->assertObjectHasMethod('getTool', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTool', $this->model);

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
        $this->tester->assertObjectHasMethod('setExtra1', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExtra1', $this->model);

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
        $this->tester->assertObjectHasMethod('getExtra1', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExtra1', $this->model);

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
        $this->tester->assertObjectHasMethod('setExtra2', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExtra2', $this->model);

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
        $this->tester->assertObjectHasMethod('getExtra2', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExtra2', $this->model);

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
        $this->tester->assertObjectHasMethod('setExtra3', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExtra3', $this->model);

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
        $this->tester->assertObjectHasMethod('getExtra3', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExtra3', $this->model);

        $this->model->setExtra3('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->model->getExtra3())->string();
        verify($this->model->getExtra3())->notEmpty();
        verify($this->model->getExtra3())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }
}
