<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Card;

/**
 * Class CardTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CardTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Card
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Card();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        expect($this->model->setId('1009'))->isInstanceOf(Card::class);
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

        $this->model->setId('1009');

        verify($this->model->getId())->string();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals('1009');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('Maestro'))->isInstanceOf(Card::class);
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

        $this->model->setName('Maestro');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('Maestro');
    }
}
