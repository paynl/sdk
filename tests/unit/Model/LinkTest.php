<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Link;

/**
 * Class LinkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class LinkTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Link
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Link();
    }

    /**
     * @return void
     */
    public function testItCanSetARel(): void
    {
        $this->tester->assertObjectHasMethod('setRel', $this->model);
        $this->tester->assertObjectMethodIsPublic('setRel', $this->model);

        expect($this->model->setRel('self'))->isInstanceOf(Link::class);
    }

    /**
     * @depends testItCanSetARel
     *
     * @return void
     */
    public function testItCanGetARel(): void
    {
        $this->tester->assertObjectHasMethod('getRel', $this->model);
        $this->tester->assertObjectMethodIsPublic('getRel', $this->model);

        $this->model->setRel('self');

        verify($this->model->getRel())->string();
        verify($this->model->getRel())->notEmpty();
        verify($this->model->getRel())->equals('self');
    }

    /**
     * @return void
     */
    public function testItCanSetAType(): void
    {
        $this->tester->assertObjectHasMethod('setType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setType', $this->model);

        expect($this->model->setType('GET'))->isInstanceOf(Link::class);
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

        $this->model->setType('GET');

        verify($this->model->getType())->string();
        verify($this->model->getType())->notEmpty();
        verify($this->model->getType())->equals('GET');
    }

    /**
     * @return void
     */
    public function testItCanSetAnUrl(): void
    {
        $this->tester->assertObjectHasMethod('setUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setUrl', $this->model);

        expect($this->model->setUrl('http://www.pay.nl'))->isInstanceOf(Link::class);
    }

    /**
     * @depends testItCanSetAnUrl
     *
     * @return void
     */
    public function testItCanGetAnUrl(): void
    {
        $this->tester->assertObjectHasMethod('getUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getUrl', $this->model);

        $this->model->setUrl('http://www.pay.nl');

        verify($this->model->getUrl())->string();
        verify($this->model->getUrl())->notEmpty();
        verify($this->model->getUrl())->equals('http://www.pay.nl');
    }
}
