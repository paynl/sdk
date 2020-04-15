<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Trademark;

/**
 * Class CurrencyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TrademarkTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Trademark
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Trademark();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        expect($this->model->setId('T-1000-0001'))->isInstanceOf(Trademark::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $this->model->setId('T-1000-0001');

        verify($this->model->getId())->string();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals('T-1000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('Pay.be'))->isInstanceOf(Trademark::class);
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

        $this->model->setName('Pay.be');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('Pay.be');
    }
}
