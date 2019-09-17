<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Company;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class CompanyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CompanyTest extends UnitTest
{
    /**
     * @var Company
     */
    protected $company;

    public function _before(): void
    {
        $this->company = new Company();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->company)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->company)->isInstanceOf(\JsonSerializable::class);

        verify($this->company->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->company->setName('PAY.'))->isInstanceOf(Company::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->company->setName('PAY.');

        verify($this->company->getName())->string();
        verify($this->company->getName())->notEmpty();
        verify($this->company->getName())->equals('PAY.');
    }

    /**
     * @return void
     */
    public function testItCanSetACoc(): void
    {
        expect($this->company->setCoc('24283498'))->isInstanceOf(Company::class);
    }

    /**
     * @depends testItCanSetACoc
     *
     * @return void
     */
    public function testItCanGetACoc(): void
    {
        $this->company->setCoc('24283498');

        verify($this->company->getCoc())->string();
        verify($this->company->getCoc())->notEmpty();
        verify($this->company->getCoc())->equals('24283498');
    }

    /**
     * @return void
     */
    public function testItCanSetAVat(): void
    {
        expect($this->company->setVat('NL807960147B01'))->isInstanceOf(Company::class);
    }

    /**
     * @depends testItCanSetAVat
     *
     * @return void
     */
    public function testItCanGetAVat(): void
    {
        $this->company->setVat('NL807960147B01');

        verify($this->company->getVat())->string();
        verify($this->company->getVat())->notEmpty();
        verify($this->company->getVat())->equals('NL807960147B01');
    }

    /**
     * @return void
     */
    public function testItCanSetACountryCode(): void
    {
        expect($this->company->setCountryCode('NL'))->isInstanceOf(Company::class);
    }

    /**
     * @depends testItCanSetACountryCode
     *
     * @return void
     */
    public function testItCanGetACountryCode(): void
    {
        $this->company->setCountryCode('NL');

        verify($this->company->getCountryCode())->string();
        verify($this->company->getCountryCode())->notEmpty();
        verify($this->company->getCountryCode())->equals('NL');
    }
}
