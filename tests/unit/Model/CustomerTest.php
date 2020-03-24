<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\{Company, ModelInterface, BankAccount, Customer};
use DateTime, JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;
use UnitTester;

/**
 * Class CustomerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CustomerTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @var Customer
     */
    protected $customer;

    public function _before(): void
    {
        $this->customer = new Customer();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->customer)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->customer)->isInstanceOf(JsonSerializable::class);

        verify($this->customer->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItUsesJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->customer), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanGetTypes(): void
    {
        $this->tester->assertObjectHasMethod('getTypes', $this->customer);
        $this->tester->assertObjectMethodIsProtected('getTypes', $this->customer);

        $types = $this->tester->invokeMethod($this->customer, 'getTypes');
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
        $types = $this->tester->invokeMethod($this->customer, 'getTypes');
        verify($this->customer->setType(Customer::TYPE_BUSINESS))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetType
     * @return void
     */
    public function testItCanGetType(): void
    {
        $types = $this->tester->invokeMethod($this->customer, 'getTypes');
        $this->customer->setType(Customer::TYPE_BUSINESS);
        $type = $this->customer->getType();
        verify($type)->string();
        verify($type)->equals(Customer::TYPE_BUSINESS);
    }

    /**
     * @depends testItCanSetType
     * @return void
     */
    public function testItCannotSetProhibitedTypes(): void
    {
        $type = 'IllegalType';
        $types = $this->tester->invokeMethod($this->customer, 'getTypes');
        verify(in_array($type, $types, true))->false();
        $this->expectException(InvalidArgumentException::class);
        $this->customer->setType($type);
    }

    /**
     * @return void
     */
    public function testItCanSetName(): void
    {
        expect($this->customer->setName('Q.G.'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetName
     *
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->customer->setName('Q.G.');

        verify($this->customer->getName())->string();
        verify($this->customer->getName())->notEmpty();
        verify($this->customer->getName())->equals('Q.G.');
    }

    /**
     * @return void
     */
    public function testItCanSetALastName(): void
    {
        expect($this->customer->setLastName('Jinn'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetALastName
     *
     * @return void
     */
    public function testItCanGetALastName(): void
    {
        $this->customer->setLastName('Jinn');

        verify($this->customer->getLastName())->string();
        verify($this->customer->getLastName())->notEmpty();
        verify($this->customer->getLastName())->equals('Jinn');
    }

    /**
     * @return void
     */
    public function testItCanSetABirthDate(): void
    {
        expect($this->customer->setBirthDate(DateTime::createFromFormat('Y-m-d', '1970-01-01')))
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
        $birthDate = DateTime::createFromFormat('Y-m-d', '1970-01-01');
        $this->customer->setBirthDate($birthDate);

        verify($this->customer->getBirthDate())->isInstanceOf(DateTime::class);
        verify($this->customer->getBirthDate())->notEmpty();
        verify($this->customer->getBirthDate())->equals($birthDate);
    }

    /**
     * @return void
     */
    public function testItCanSetAGender(): void
    {
        expect($this->customer->setGender('male'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAGender
     *
     * @return void
     */
    public function testItCanGetAGender(): void
    {
        $this->customer->setGender('male');

        verify($this->customer->getGender())->string();
        verify($this->customer->getGender())->notEmpty();
        verify($this->customer->getGender())->equals('male');
    }

    /**
     * @return void
     */
    public function testItCanSetAPhone(): void
    {
        expect($this->customer->setPhone('+31 (0)88 - 88 666 66'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAPhone
     *
     * @return void
     */
    public function testItCanGetAPhone(): void
    {
        $this->customer->setPhone('+31 (0)88 - 88 666 66');

        verify($this->customer->getPhone())->string();
        verify($this->customer->getPhone())->notEmpty();
        verify($this->customer->getPhone())->equals('+31 (0)88 - 88 666 66');
    }

    /**
     * @return void
     */
    public function testItCanSetAnIp(): void
    {
        expect($this->customer->setIp('127.0.0.1'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAnIp
     *
     * @return void
     */
    public function testItCanGetAnIp(): void
    {
        $this->customer->setIp('127.0.0.1');

        verify($this->customer->getIp())->string();
        verify($this->customer->getIp())->notEmpty();
        verify($this->customer->getIp())->equals('127.0.0.1');
    }

    /**
     * @return void
     */
    public function testItCanSetAnEmail(): void
    {
        expect($this->customer->setEmail('qui.gon@jedi-counsil.gov'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAnEmail
     *
     * @return void
     */
    public function testItCanGetAnEmail(): void
    {
        $this->customer->setEmail('qui.gon@jedi-counsil.gov');

        verify($this->customer->getEmail())->string();
        verify($this->customer->getEmail())->notEmpty();
        verify($this->customer->getEmail())->equals('qui.gon@jedi-counsil.gov');
    }

    /**
     * @return void
     */
    public function testItCanSetATrustLevel(): void
    {
        expect($this->customer->setTrustLevel(-5))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetATrustLevel
     *
     * @return void
     */
    public function testItCanGetATrustLevel(): void
    {
        $this->customer->setTrustLevel(-5);

        verify($this->customer->getTrustLevel())->int();
        verify($this->customer->getTrustLevel())->notEmpty();
        verify($this->customer->getTrustLevel())->equals(-5);
    }

    /**
     * @depends testItCanSetATrustLevel
     * @return void
     */
    public function testItCannotSetInvalidTrustLevel(): void
    {
        $invalidTrustLevel = 11;
        $this->expectException(InvalidArgumentException::class);
        $this->customer->setTrustLevel($invalidTrustLevel);
    }

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        expect($this->customer->setBankAccount(new BankAccount()))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetABankAccount
     *
     * @return void
     */
    public function testItCanGetABankAccount(): void
    {
        $this->customer->setBankAccount(new BankAccount());

        verify($this->customer->getBankAccount())->notEmpty();
        verify($this->customer->getBankAccount())->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAReference(): void
    {
        expect($this->customer->setReference('1234'))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetAReference
     *
     * @return void
     */
    public function testItCanGetAReference(): void
    {
        $this->customer->setReference('1234');

        verify($this->customer->getReference())->string();
        verify($this->customer->getReference())->notEmpty();
        verify($this->customer->getReference())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetACompany(): void
    {
        $company = $this->tester->getServiceManager()->get('modelManager')->build('Company');
        verify($this->customer->setCompany($company))->isInstanceOf(Customer::class);
    }

    /**
     * @depends testItCanSetACompany
     * @return void
     */
    public function testItCanGetACompany(): void
    {
        /** @var Company $company */
        $company = $this->tester->getServiceManager()->get('modelManager')->build('Company');
        $company->setName('TestCompany');
        $this->customer->setCompany($company);
        verify($this->customer->getCompany())->isInstanceOf(Company::class);
        verify($this->customer->getCompany())->equals($company);
    }
}
