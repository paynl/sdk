<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Company;

/**
 * Class CompanyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CompanyTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Company
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Company();
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('PAY.'))->isInstanceOf(Company::class);
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

        $this->model->setName('PAY.');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('PAY.');
    }

    /**
     * @return void
     */
    public function testItCanSetACoc(): void
    {
        $this->tester->assertObjectHasMethod('setCoc', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCoc', $this->model);

        expect($this->model->setCoc('24283498'))->isInstanceOf(Company::class);
    }

    /**
     * @depends testItCanSetACoc
     *
     * @return void
     */
    public function testItCanGetACoc(): void
    {
        $this->tester->assertObjectHasMethod('getCoc', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCoc', $this->model);

        $this->model->setCoc('24283498');

        verify($this->model->getCoc())->string();
        verify($this->model->getCoc())->notEmpty();
        verify($this->model->getCoc())->equals('24283498');
    }

    /**
     * @return void
     */
    public function testItCanSetAVat(): void
    {
        $this->tester->assertObjectHasMethod('setVat', $this->model);
        $this->tester->assertObjectMethodIsPublic('setVat', $this->model);

        expect($this->model->setVat('NL807960147B01'))->isInstanceOf(Company::class);
    }

    /**
     * @depends testItCanSetAVat
     *
     * @return void
     */
    public function testItCanGetAVat(): void
    {
        $this->tester->assertObjectHasMethod('getVat', $this->model);
        $this->tester->assertObjectMethodIsPublic('getVat', $this->model);

        $this->model->setVat('NL807960147B01');

        verify($this->model->getVat())->string();
        verify($this->model->getVat())->notEmpty();
        verify($this->model->getVat())->equals('NL807960147B01');
    }

    /**
     * @return void
     */
    public function testItCanSetACountryCode(): void
    {
        $this->tester->assertObjectHasMethod('setCountryCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCountryCode', $this->model);

        expect($this->model->setCountryCode('NL'))->isInstanceOf(Company::class);
    }

    /**
     * @depends testItCanSetACountryCode
     *
     * @return void
     */
    public function testItCanGetACountryCode(): void
    {
        $this->tester->assertObjectHasMethod('getCountryCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCountryCode', $this->model);

        $this->model->setCountryCode('NL');

        verify($this->model->getCountryCode())->string();
        verify($this->model->getCountryCode())->notEmpty();
        verify($this->model->getCountryCode())->equals('NL');
    }
}
