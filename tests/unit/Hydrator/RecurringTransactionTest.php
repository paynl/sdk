<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\RecurringTransaction as RecurringTransactionHydrator;
use PayNL\Sdk\Model\{
    RecurringTransaction,
    Amount
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class RecurringTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class RecurringTransactionTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new RecurringTransactionHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new RecurringTransactionHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new RecurringTransaction()))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new RecurringTransactionHydrator();
        $recurringTransaction = $hydrator->hydrate([
            'amount' => [
                'amount'   => 10,
                'currency' => 'EUR'
            ],
            'description' => 'Test recurring',
            'extra1'      => 'Extra 1',
            'extra2'      => 'Extra 2',
            'extra3'      => 'Extra 3',
        ], new RecurringTransaction());

        expect($recurringTransaction->getAmount())->isInstanceOf(Amount::class);
        expect($recurringTransaction->getDescription())->equals('Test recurring');
        expect($recurringTransaction->getExtra1())->equals('Extra 1');
        expect($recurringTransaction->getExtra2())->equals('Extra 2');
        expect($recurringTransaction->getExtra3())->equals('Extra 3');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new RecurringTransactionHydrator();
        $recurringTransaction = $hydrator->hydrate([
            'amount' => [
                'amount'   => 10,
                'currency' => 'EUR'
            ],
            'description' => 'Test recurring',
            'extra1'      => 'Extra 1',
            'extra2'      => 'Extra 2',
            'extra3'      => 'Extra 3',
        ], new RecurringTransaction());

        $data = $hydrator->extract($recurringTransaction);
        $this->assertIsArray($data);
        verify($data)->hasKey('amount');
        verify($data)->hasKey('description');
        verify($data)->hasKey('extra1');
        verify($data)->hasKey('extra2');
        verify($data)->hasKey('extra3');

        expect($data['amount'])->isInstanceOf(Amount::class);
        expect($data['description'])->equals('Test recurring');
        expect($data['extra1'])->equals('Extra 1');
        expect($data['extra2'])->equals('Extra 2');
        expect($data['extra3'])->equals('Extra 3');
    }
}
