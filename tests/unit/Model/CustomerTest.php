<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\{
    Company,
    BankAccount,
    Customer
};
use DateTime;

/**
 * Class CustomerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CustomerTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Customer
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Customer();
    }

    /**
     * @return void
     */
    public function testItCanGetTypes(): void
    {
        $this->tester->assertObjectHasMethod('getTypes', $this->model);
        $this->tester->assertObjectMethodIsProtected('getTypes', $this->model);

        $types = $this->tester->invokeMethod($this->model, 'getTypes');
        verify($types)->array();
        verify($types)->notEmpty();
        verify($types)->count(2);
        verify($types)->contains(Customer::TYPE_BUSINESS);
        verify($types)->contains(Customer::TYPE_CONSUMER);
    }

    /**
     * @depends testItCanGetTypes
     * @return void
     */
    public function testItCanSetType(): void
    {
        $this->tester->assertObjectHasMethod('setType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setType', $this->model);

        $types = $this->tester->invokeMethod($this->model, 'getTypes');
        verify($this->model->setType(Customer::TYPE_BUSINESS))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetType
     * @return void
     */
    public function testItCanGetType(): void
    {
        $this->tester->assertObjectHasMethod('getType', $this->model);
        $this->tester->assertObjectMethodIsPublic('getType', $this->model);

        $type = $this->model->getType();
        verify($type)->equals(Customer::TYPE_DEFAULT);

        $this->model->setType(Customer::TYPE_BUSINESS);
        $type = $this->model->getType();
        verify($type)->string();
        verify($type)->equals(Customer::TYPE_BUSINESS);
    }

    /**
     * @depends testItCanSetType
     * @return void
     */
    public function testItCannotSetProhibitedTypes(): void
    {
        $this->tester->assertObjectHasMethod('setType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setType', $this->model);

        $type = 'IllegalType';
        $types = $this->tester->invokeMethod($this->model, 'getTypes');
        verify(in_array($type, $types, true))->false();
        $this->expectException(InvalidArgumentException::class);
        $this->model->setType($type);
    }

    /**
     * @return void
     */
    public function testItCanSetName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('Q.G.'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetName
     *
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $this->model->setName('Q.G.');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('Q.G.');
    }

    /**
     * @return void
     */
    public function testItCanSetALastName(): void
    {
        $this->tester->assertObjectHasMethod('setLastName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setLastName', $this->model);

        expect($this->model->setLastName('Jinn'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetALastName
     *
     * @return void
     */
    public function testItCanGetALastName(): void
    {
        $this->tester->assertObjectHasMethod('getLastName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getLastName', $this->model);

        $this->model->setLastName('Jinn');

        verify($this->model->getLastName())->string();
        verify($this->model->getLastName())->notEmpty();
        verify($this->model->getLastName())->equals('Jinn');
    }

    /**
     * @return void
     */
    public function testItCanSetABirthDate(): void
    {
        $this->tester->assertObjectHasMethod('setBirthDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBirthDate', $this->model);

        expect($this->model->setBirthDate(DateTime::createFromFormat('Y-m-d', '1970-01-01')))
            ->isInstanceOf(Customer::class)
        ;
    }

    /**
     * @depends testItCanSetABirthDate
     *
     * @return void
     */
    public function testItCanGetABirthDate(): void
    {
        $this->tester->assertObjectHasMethod('getBirthDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getBirthDate', $this->model);

        $birthDate = DateTime::createFromFormat('Y-m-d', '1970-01-01');
        $this->model->setBirthDate($birthDate);

        verify($this->model->getBirthDate())->isInstanceOf(DateTime::class);
        verify($this->model->getBirthDate())->notEmpty();
        verify($this->model->getBirthDate())->equals($birthDate);
    }

    /**
     * @return void
     */
    public function testItCanSetAGender(): void
    {
        $this->tester->assertObjectHasMethod('setGender', $this->model);
        $this->tester->assertObjectMethodIsPublic('setGender', $this->model);

        expect($this->model->setGender('male'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAGender
     *
     * @return void
     */
    public function testItCanGetAGender(): void
    {
        $this->tester->assertObjectHasMethod('getGender', $this->model);
        $this->tester->assertObjectMethodIsPublic('getGender', $this->model);

        $this->model->setGender('male');

        verify($this->model->getGender())->string();
        verify($this->model->getGender())->notEmpty();
        verify($this->model->getGender())->equals('male');
    }

    /**
     * @return void
     */
    public function testItCanSetAPhone(): void
    {
        $this->tester->assertObjectHasMethod('setPhone', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPhone', $this->model);

        expect($this->model->setPhone('+31 (0)88 - 88 666 66'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAPhone
     *
     * @return void
     */
    public function testItCanGetAPhone(): void
    {
        $this->tester->assertObjectHasMethod('getPhone', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPhone', $this->model);

        $this->model->setPhone('+31 (0)88 - 88 666 66');

        verify($this->model->getPhone())->string();
        verify($this->model->getPhone())->notEmpty();
        verify($this->model->getPhone())->equals('+31 (0)88 - 88 666 66');
    }

    /**
     * @return void
     */
    public function testItCanSetAnIp(): void
    {
        $this->tester->assertObjectHasMethod('setIp', $this->model);
        $this->tester->assertObjectMethodIsPublic('setIp', $this->model);

        expect($this->model->setIp('127.0.0.1'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAnIp
     *
     * @return void
     */
    public function testItCanGetAnIp(): void
    {
        $this->tester->assertObjectHasMethod('getIp', $this->model);
        $this->tester->assertObjectMethodIsPublic('getIp', $this->model);

        $this->model->setIp('127.0.0.1');

        verify($this->model->getIp())->string();
        verify($this->model->getIp())->notEmpty();
        verify($this->model->getIp())->equals('127.0.0.1');
    }

    /**
     * @return void
     */
    public function testItCanSetAnEmail(): void
    {
        $this->tester->assertObjectHasMethod('setEmail', $this->model);
        $this->tester->assertObjectMethodIsPublic('setEmail', $this->model);

        expect($this->model->setEmail('qui.gon@jedi-counsil.gov'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAnEmail
     *
     * @return void
     */
    public function testItCanGetAnEmail(): void
    {
        $this->tester->assertObjectHasMethod('getEmail', $this->model);
        $this->tester->assertObjectMethodIsPublic('getEmail', $this->model);

        $this->model->setEmail('qui.gon@jedi-counsil.gov');

        verify($this->model->getEmail())->string();
        verify($this->model->getEmail())->notEmpty();
        verify($this->model->getEmail())->equals('qui.gon@jedi-counsil.gov');
    }

    /**
     * @return void
     */
    public function testItCanSetATrustLevel(): void
    {
        $this->tester->assertObjectHasMethod('setTrustLevel', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTrustLevel', $this->model);

        expect($this->model->setTrustLevel(-5))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetATrustLevel
     *
     * @return void
     */
    public function testItCanGetATrustLevel(): void
    {
        $this->tester->assertObjectHasMethod('getTrustLevel', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTrustLevel', $this->model);

        $this->model->setTrustLevel(-5);

        verify($this->model->getTrustLevel())->int();
        verify($this->model->getTrustLevel())->notEmpty();
        verify($this->model->getTrustLevel())->equals(-5);
    }

    /**
     * @depends testItCanSetATrustLevel
     * @return void
     */
    public function testItCannotSetInvalidTrustLevel(): void
    {
        $this->tester->assertObjectHasMethod('setTrustLevel', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTrustLevel', $this->model);

        $invalidTrustLevel = 11;
        $this->expectException(InvalidArgumentException::class);
        $this->model->setTrustLevel($invalidTrustLevel);
    }

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        $this->tester->assertObjectHasMethod('setBankAccount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBankAccount', $this->model);

        expect($this->model->setBankAccount(new BankAccount()))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetABankAccount
     *
     * @return void
     */
    public function testItCanGetABankAccount(): void
    {
        $this->tester->assertObjectHasMethod('getBankAccount', $this->model);
        $this->tester->assertObjectMethodIsPublic('getBankAccount', $this->model);

        $this->model->setBankAccount(new BankAccount());

        verify($this->model->getBankAccount())->notEmpty();
        verify($this->model->getBankAccount())->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAReference(): void
    {
        $this->tester->assertObjectHasMethod('setReference', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReference', $this->model);

        expect($this->model->setReference('1234'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAReference
     *
     * @return void
     */
    public function testItCanGetAReference(): void
    {
        $this->tester->assertObjectHasMethod('getReference', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReference', $this->model);

        $this->model->setReference('1234');

        verify($this->model->getReference())->string();
        verify($this->model->getReference())->notEmpty();
        verify($this->model->getReference())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetACompany(): void
    {
        $this->tester->assertObjectHasMethod('setCompany', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCompany', $this->model);

        $company = $this->tester->getServiceManager()->get('modelManager')->build('Company');
        verify($this->model->setCompany($company))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetACompany
     * @return void
     */
    public function testItCanGetACompany(): void
    {
        $this->tester->assertObjectHasMethod('getCompany', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCompany', $this->model);

        verify($this->model->getCompany())->isInstanceOf(Company::class);

        /** @var Company $company */
        $company = $this->tester->getServiceManager()->get('modelManager')->build('Company');
        $company->setName('TestCompany');
        $this->model->setCompany($company);
        verify($this->model->getCompany())->isInstanceOf(Company::class);
        verify($this->model->getCompany())->equals($company);
    }
}
