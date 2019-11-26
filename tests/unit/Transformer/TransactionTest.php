<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Transaction as TransactionTransformer,
    TransformerInterface
};
use PayNL\Sdk\DateTime;
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

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->transactionTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'transactions' => [
                [
                    'id' => 484512854
                ],
                [
                    'id' => 484512855
                ],
            ],
        ]);

        $output = $this->transactionTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('transactions');
        verify($output['transactions'])->array();
        verify($output['transactions'])->count(2);
        verify($output['transactions'])->containsOnlyInstancesOf(Transaction::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformSingle(): void
    {
        $input = json_encode([
            'id' => 484512854,
            'serviceId' => 'SL-1000-0001',
            'status' => [
                'code'   => 316,
                'name'   => 'processed',
                'date'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
                'reason' => 'Just because...'
            ],
            'returnUrl' => 'https://www.pay.nl/return-url',
            'exchangeUrl' => 'https://www.pay.nl/exchange-url',
            'reference' => '',
            'paymentMethod' => [
                'id' => 10,
                'name' => 'ideal',
            ],
            'description' => 'Test description',
            'issuerUrl' => '',
            'orderNumber' => '',
            'invoiceDate' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'deliveryDate' => '2019-09-11T14:57:16+02:00',
            'address' => [
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ],
            'billingAddress' => [
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ],
            'customer' => [
                'initials' => 'B',
                'firstName' => 'Bruce',
                'lastName' => 'Wayne',
                'ip' => '10.0.0.1',
                'birthDate' => '1970-01-01T01:00:00+02:00',
                'gender' => 'M',
                'phone' => '612121212',
                'email' => 'b.wayne@wayne-enterprises.com',
                'trustLevel' => '-5',
                'bankAccount' => [
                    'iban' => 'NL91ABNA0417164300',
                    'bic' => 'INGBNL2A',
                    'owner' => 'Bruce Wayne'
                ],
                'reference' => '123456789',
                'language' => 'NL',
            ],
            'products' => [
                [
                    'id' => 'P-1000-00021',
                    'description' => 'Tumbler',
                    'price' => [
                        'amount' => '2500000',
                        'currency' => 'USD'
                    ],
                    'quantity' => 1,
                    'vat' => 0
                ],
            ],
            'amount' => [
                'amount'   => 34500,
                'currency' => 'USD'
            ],
            'amountConverted' => [
                'amount'   => 28000,
                'currency' => 'EUR'
            ],
            'amountPaid' => [
                'amount'   => 28000,
                'currency' => 'EUR'
            ],
            'amountRefunded' => [
                'amount'   => 0,
                'currency' => 'EUR'
            ],
            'statistics' => [
                'promoterId' => 0,
                'info' => 'This is information',
                'tool' => 'I use this tool',
                'extra1' => '',
                'extra2' => '',
                'extra3' => '',
                'transferData' => [
                    'dataaaaa'
                ]
            ],
            'createdAt' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'expiresAt' => '2019-12-31T00:00:00+02:00',
            'testMode' => 0,
            'transferType' => 'merchant',
            'transferValue' => 'M-1000-1000',
            'endUserId' => '0',
            'company' => [
                'name' => 'Wayne Enterprises Inc.',
                'coc' => '12345678',
                'vat' => '24456789B01',
                'countryCode' => 'US'
            ],
        ]);

        $output = $this->transactionTransformer->transform($input);
        verify($output)->isInstanceOf(Transaction::class);
    }
}
