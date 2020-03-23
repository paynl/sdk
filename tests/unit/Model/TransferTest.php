<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Transfer;

/**
 * Class TransferTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TransferTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Transfer
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->shouldItBeJsonSerializable = true;
        $this->model = new Transfer();
    }

    /**
     * @return void
     */
    public function testItCanSetType(): void
    {
        $this->tester->assertObjectHasMethod('setType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setType', $this->model);

        $transfer = $this->model->setType('foo');
        verify($transfer)->object();
        verify($transfer)->same($this->model);
    }

    /**
     * @depends testItCanSetType
     *
     * @return void
     */
    public function testItCanGetType(): void
    {
        $this->tester->assertObjectHasMethod('getType', $this->model);
        $this->tester->assertObjectMethodIsPublic('getType', $this->model);

        $type = $this->model->getType();
        verify($type)->string();
        verify($type)->isEmpty();

        $this->model->setType('foo');
        $type = $this->model->getType();
        verify($type)->string();
        verify($type)->notEmpty();
        verify($type)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetValue(): void
    {
        $this->tester->assertObjectHasMethod('setValue', $this->model);
        $this->tester->assertObjectMethodIsPublic('setValue', $this->model);

        $transfer = $this->model->setValue('foo');
        verify($transfer)->object();
        verify($transfer)->same($this->model);
    }

    /**
     * @depends testItCanSetValue
     *
     * @return void
     */
    public function testItCanGetValue(): void
    {
        $this->tester->assertObjectHasMethod('getValue', $this->model);
        $this->tester->assertObjectMethodIsPublic('getValue', $this->model);

        $value = $this->model->getValue();
        verify($value)->string();
        verify($value)->isEmpty();

        $this->model->setValue('foo');
        $value = $this->model->getValue();
        verify($value)->string();
        verify($value)->notEmpty();
        verify($value)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetData(): void
    {
        $this->tester->assertObjectHasMethod('setData', $this->model);
        $this->tester->assertObjectMethodIsPublic('setData', $this->model);

        $transfer = $this->model->setData(['foo', 'bar']);
        verify($transfer)->object();
        verify($transfer)->same($this->model);
    }

    /**
     * @depends testItCanSetData
     *
     * @return void
     */
    public function testItCanGetData(): void
    {
        $this->tester->assertObjectHasMethod('getData', $this->model);
        $this->tester->assertObjectMethodIsPublic('getData', $this->model);

        $data = $this->model->getData();
        verify($data)->array();
        verify($data)->isEmpty();

        $this->model->setData(['foo', 'bar']);
        $data = $this->model->getData();
        verify($data)->array();
        verify($data)->notEmpty();
        verify($data)->count(2);
        verify($data)->contains('foo');
        verify($data)->contains('bar');
    }
}
