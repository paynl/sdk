<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Transaction as TransactionTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\Transaction;

/**
 * Class TransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class TransactionTest extends UnitTest
{
    /**
     * @var TransactionTransformer
     */
    protected $transactionTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->transactionTransformer = new TransactionTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->transactionTransformer)->isInstanceOf(TransformerInterface::class);
    }

    public function testItExtendsAbstract(): void
    {
        verify($this->transactionTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'transactions' => [
                [],
                [],
            ],
        ]);

        $output = $this->transactionTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('transactions');
        verify($output['transactions'])->array();
        verify($output['transactions'])->count(2);
        verify($output['transactions'])->containsOnlyInstancesOf(Transaction::class);
    }

    // TODO fix the transaction transformer test

//    public function testItCanTransformSingle(): void
//    {
//        $input = json_encode([
//            'abbreviation' => 'EUR',
//            'description'  => 'Euro',
//        ]);
//
//        $output = $this->merchantTransformer->transform($input);
//        verify($output)->isInstanceOf(Currency::class);
//    }
}
