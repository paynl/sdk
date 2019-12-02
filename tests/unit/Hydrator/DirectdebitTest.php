<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Hydrator\Directdebit as DirectdebitHydrator;
use PayNL\Sdk\Model\{
    Amount,
    BankAccount,
    Directdebit,
    Status
};
use PayNL\Sdk\Exception\InvalidArgumentException;
use Zend\Hydrator\HydratorInterface;

/**
 * Class DirectdebitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class DirectdebitTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new DirectdebitHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptADirectdebitModel(): void
    {
        $hydrator = new DirectdebitHydrator();
        expect($hydrator->hydrate([], new Directdebit()))->isInstanceOf(Directdebit::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new DirectdebitHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new DirectdebitHydrator();
        $directdebit = $hydrator->hydrate([
            'id'               => 'IL-6140-0584-1230',
            'paymentSessionId' => '1149497187',
            'amount'           => [
                'amount'   => 100,
                'currency' => 'EUR',
            ],
            'description'      => 'Test',
            'bankAccount'      => [
                'iban'  => 'NL00ABNA00000000',
                'bic'   => 'ABNANL2A',
                'owner' => 'J. the Hutt',
            ],
            'status'           => [
                'code'   =>  '94',
                'name'   =>  'Verwerkt',
                'date'   =>  null,
                'reason' =>  '',
            ],
            'declined'         => [
                'code'   => '-72',
                'name'   => 'Blaatschaap',
                'date'   => null,
                'reason' => 'zomaar',
            ],
        ], new Directdebit());

        expect($directdebit->getId())->string();
        expect($directdebit->getId())->equals('IL-6140-0584-1230');
        expect($directdebit->getPaymentSessionId())->string();
        expect($directdebit->getPaymentSessionId())->equals('1149497187');
        expect($directdebit->getAmount())->isInstanceOf(Amount::class);
        expect($directdebit->getDescription())->string();
        expect($directdebit->getDescription())->equals('Test');
        expect($directdebit->getBankAccount())->isInstanceOf(BankAccount::class);
        expect($directdebit->getStatus())->isInstanceOf(Status::class);
        expect($directdebit->getDeclined())->isInstanceOf(Status::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new DirectdebitHydrator();
        $directdebit = $hydrator->hydrate([
            'id'               => 'IL-6140-0584-1230',
            'paymentSessionId' => '1149497187',
            'amount'           => [
                'amount'   => 100,
                'currency' => 'EUR',
            ],
            'description'      => 'Test',
            'bankAccount'      => [
                'iban'  => 'NL00ABNA00000000',
                'bic'   => 'ABNANL2A',
                'owner' => 'J. the Hutt',
            ],
            'status'           => [
                'code'   =>  '94',
                'name'   =>  'Verwerkt',
                'date'   =>  null,
                'reason' =>  '',
            ],
            'declined'         => [],
        ], new Directdebit());

        $data = $hydrator->extract($directdebit);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('paymentSessionId');
        verify($data)->hasKey('amount');
        verify($data)->hasKey('description');
        verify($data)->hasKey('bankAccount');
        verify($data)->hasKey('status');
        verify($data)->hasKey('declined');

        expect($data['id'])->string();
        expect($data['id'])->equals('IL-6140-0584-1230');
        expect($data['paymentSessionId'])->string();
        expect($data['paymentSessionId'])->equals('1149497187');
        expect($data['amount'])->isInstanceOf(Amount::class);
        expect($data['description'])->string();
        expect($data['description'])->equals('Test');
        expect($data['bankAccount'])->isInstanceOf(BankAccount::class);
        expect($data['status'])->isInstanceOf(Status::class);
        expect($data['declined'])->null();
    }
}
