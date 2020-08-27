<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Member\LinksAwareTrait,
    Currency
};

/**
 * Class CurrencyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CurrencyTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Currency
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Currency();
    }

    public function testItUsesLinksTrait(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksAwareTrait::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAbbreviation(): void
    {
        $this->tester->assertObjectHasMethod('setAbbreviation', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAbbreviation', $this->model);

        verify($this->model->setAbbreviation('EUR'))->isInstanceOf(Currency::class);
    }

    /**
     * @depends testItCanSetAnAbbreviation
     *
     * @return void
     */
    public function testItCanGetAnAbbreviation(): void
    {
        $this->tester->assertObjectHasMethod('getAbbreviation', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAbbreviation', $this->model);

        $this->model->setAbbreviation('EUR');

        verify($this->model->getAbbreviation())->string();
        verify($this->model->getAbbreviation())->notEmpty();
        verify($this->model->getAbbreviation())->equals('EUR');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        verify($this->model->setDescription('Euro'))->isInstanceOf(Currency::class);
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

        $this->model->setDescription('Euro');

        verify($this->model->getDescription())->string();
        verify($this->model->getDescription())->notEmpty();
        verify($this->model->getDescription())->equals('Euro');
    }
}
