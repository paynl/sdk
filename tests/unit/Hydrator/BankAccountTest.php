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
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new BankAccountHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new BankAccount()))->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new BankAccountHydrator();
        $bankAccount = $hydrator->hydrate([
            'iban'  => 'NL00RABO0123456789',
            'bic'   => 'NL00RABO',
            'owner' => 'H. Solo',
        ], new BankAccount());

        expect($bankAccount->getIban())->equals('NL00RABO0123456789');
        expect($bankAccount->getBic())->equals('NL00RABO');
        expect($bankAccount->getOwner())->equals('H. Solo');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new BankAccountHydrator();
        $bankAccount = $hydrator->hydrate([
            'iban'  => 'NL00RABO0123456789',
            'bic'   => 'NL00RABO',
            'owner' => 'H. Solo',
        ], new BankAccount());

        $data = $hydrator->extract($bankAccount);
        $this->assertIsArray($data);
        verify($data)->hasKey('iban');
        verify($data)->hasKey('bic');
        verify($data)->hasKey('owner');

        expect($data['iban'])->equals('NL00RABO0123456789');
        expect($data['bic'])->equals('NL00RABO');
        expect($data['owner'])->equals('H. Solo');
    }
}
