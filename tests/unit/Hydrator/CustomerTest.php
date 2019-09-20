<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\{
    BankAccount as BankAccountHydrator,
    Customer as CustomerHydrator
};
use PayNL\Sdk\Model\{
    BankAccount,
    Customer
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class CustomerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class CustomerTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new CustomerHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new CustomerHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new Customer()))->isInstanceOf(Customer::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new CustomerHydrator();
        $customer = $hydrator->hydrate([
            'initials'    => 'M',
            'lastName'    => 'Windu',
            'gender'      => 'male',
            'phone'       => '+441115551234',
            'email'       => 'mace@purple-lightsabers-rule.com',
            'trustLevel'  => '1',
            'reference'   => 'SW1-3',
            'language'    => 'EN',
            'bankAccount' => (new BankAccountHydrator())->hydrate([
                'iban'   => '021000021',
                'bic'    => 'BOFAUS3N',
                'owner' => 'M. Windu'
            ], new BankAccount()),
            'birthDate'   => DateTime::createFromFormat('Y-m-d', '1970-01-01'),
        ], new Customer());

        expect($customer->getInitials())->equals('M');
        expect($customer->getLastName())->equals('Windu');
        expect($customer->getGender())->equals('male');
        expect($customer->getPhone())->equals('+441115551234');
        expect($customer->getEmail())->equals('mace@purple-lightsabers-rule.com');
        expect($customer->getTrustLevel())->equals('1');
        expect($customer->getReference())->equals('SW1-3');
        expect($customer->getLanguage())->equals('EN');
        expect($customer->getBankAccount())->isInstanceOf(BankAccount::class);
        expect($customer->getBankAccount()->getIban())->equals('021000021');
        expect($customer->getBankAccount()->getBic())->equals('BOFAUS3N');
        expect($customer->getBankAccount()->getOwner())->equals('M. Windu');
        expect($customer->getBirthDate())->isInstanceOf(DateTime::class);
        expect($customer->getBirthDate()->format('Y-m-d'))->equals('1970-01-01');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new CustomerHydrator();
        $customer = $hydrator->hydrate([
            'initials'    => 'M',
            'lastName'    => 'Windu',
            'gender'      => 'male',
            'phone'       => '+441115551234',
            'email'       => 'mace@purple-lightsabers-rule.com',
            'trustLevel'  => '1',
            'reference'   => 'SW1-3',
            'language'    => 'EN',
            'bankAccount' => (new BankAccountHydrator())->hydrate([
                'iban'   => '021000021',
                'bic'    => 'BOFAUS3N',
                'owner' => 'M. Windu'
            ], new BankAccount()),
            'birthDate'   => DateTime::createFromFormat('Y-m-d', '1970-01-01'),
        ], new Customer());

        $data = $hydrator->extract($customer);
        $this->assertIsArray($data);
        verify($data)->hasKey('initials');
        verify($data)->hasKey('lastName');
        verify($data)->hasKey('gender');
        verify($data)->hasKey('phone');
        verify($data)->hasKey('email');
        verify($data)->hasKey('trustLevel');
        verify($data)->hasKey('reference');
        verify($data)->hasKey('bankAccount');
        verify($data)->hasKey('birthDate');

        expect($data['initials'])->equals('M');
        expect($data['lastName'])->equals('Windu');
        expect($data['gender'])->equals('male');
        expect($data['phone'])->equals('+441115551234');
        expect($data['email'])->equals('mace@purple-lightsabers-rule.com');
        expect($data['trustLevel'])->equals('1');
        expect($data['reference'])->equals('SW1-3');
        expect($data['language'])->equals('EN');
        expect($data['bankAccount'])->isInstanceOf(BankAccount::class);
        expect($data['birthDate'])->isInstanceOf(DateTime::class);
    }
}