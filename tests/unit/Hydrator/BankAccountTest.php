<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\BankAccount as BankAccountHydrator;
use PayNL\Sdk\Model\BankAccount;
use Zend\Hydrator\HydratorInterface;

/**
 * Class BankAccountTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class BankAccountTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new BankAccountHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptABankAccountModel(): void
    {
        $hydrator = new BankAccountHydrator();
        expect($hydrator->hydrate([], new BankAccount()))->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new BankAccountHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new BankAccountHydrator();
        $bankAccount = $hydrator->hydrate([
            'bank'      => 'Rabobank',
            'iban'      => 'NL00RABO0123456789',
            'bic'       => 'NL00RABO',
            'owner'     => 'H. Solo',
            'returnUrl' => 'https://www.pay.nl/return-url',
        ], new BankAccount());

        expect($bankAccount->getBank())->string();
        expect($bankAccount->getBank())->equals('Rabobank');
        expect($bankAccount->getIban())->string();
        expect($bankAccount->getIban())->equals('NL00RABO0123456789');
        expect($bankAccount->getBic())->string();
        expect($bankAccount->getBic())->equals('NL00RABO');
        expect($bankAccount->getOwner())->string();
        expect($bankAccount->getOwner())->equals('H. Solo');
        expect($bankAccount->getReturnUrl())->string();
        expect($bankAccount->getReturnUrl())->equals('https://www.pay.nl/return-url');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new BankAccountHydrator();
        $bankAccount = $hydrator->hydrate([
            'bank'      => 'Rabobank',
            'iban'      => 'NL00RABO0123456789',
            'bic'       => 'NL00RABO',
            'owner'     => 'H. Solo',
            'returnUrl' => 'https://www.pay.nl/return-url',
        ], new BankAccount());

        $data = $hydrator->extract($bankAccount);
        $this->assertIsArray($data);
        verify($data)->hasKey('bank');
        verify($data)->hasKey('iban');
        verify($data)->hasKey('bic');
        verify($data)->hasKey('owner');
        verify($data)->hasKey('returnUrl');

        expect($data['bank'])->string();
        expect($data['bank'])->equals('Rabobank');
        expect($data['iban'])->string();
        expect($data['iban'])->equals('NL00RABO0123456789');
        expect($data['bic'])->string();
        expect($data['bic'])->equals('NL00RABO');
        expect($data['owner'])->string();
        expect($data['owner'])->equals('H. Solo');
        expect($data['returnUrl'])->string();
        expect($data['returnUrl'])->equals('https://www.pay.nl/return-url');
    }
}
