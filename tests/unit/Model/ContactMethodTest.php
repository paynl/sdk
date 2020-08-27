<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\ContactMethod;

/**
 * Class ContactMethodTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ContactMethodTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var ContactMethod
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new ContactMethod();
    }

    /**
     * @return void
     */
    public function testItCanSetAType(): void
    {
        $this->tester->assertObjectHasMethod('setType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setType', $this->model);


        expect($this->model->setType('email'))->isInstanceOf(ContactMethod::class);
    }

    /**
     * @depends testItCanSetAType
     *
     * @return void
     */
    public function testItCanGetAType(): void
    {
        $this->tester->assertObjectHasMethod('getType', $this->model);
        $this->tester->assertObjectMethodIsPublic('getType', $this->model);


        $this->model->setType('email');

        verify($this->model->getType())->string();
        verify($this->model->getType())->notEmpty();
        verify($this->model->getType())->equals('email');
    }

    /**
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        $this->tester->assertObjectHasMethod('setValue', $this->model);
        $this->tester->assertObjectMethodIsPublic('setValue', $this->model);


        expect($this->model->setValue('support@pay.nl'))->isInstanceOf(ContactMethod::class);
    }

    /**
     * @depends testItCanSetAValue
     *
     * @return void
     */
    public function testItCanGetAValue(): void
    {
        $this->tester->assertObjectHasMethod('getValue', $this->model);
        $this->tester->assertObjectMethodIsPublic('getValue', $this->model);


        $this->model->setValue('support@pay.nl');

        verify($this->model->getValue())->string();
        verify($this->model->getValue())->notEmpty();
        verify($this->model->getValue())->equals('support@pay.nl');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);


        expect($this->model->setDescription('Support desk'))->isInstanceOf(ContactMethod::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->tester->assertObjectHasMethod('getDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDescription', $this->model);


        $this->model->setDescription('Support desk');

        verify($this->model->getDescription())->string();
        verify($this->model->getDescription())->notEmpty();
        verify($this->model->getDescription())->equals('Support desk');
    }
}
