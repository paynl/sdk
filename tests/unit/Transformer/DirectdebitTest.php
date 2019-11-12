<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Directdebit as DirectdebitTransformer,
    TransformerInterface
};
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\{
    Directdebit,
    Mandate,
    Links,
    Link
};
use Exception;

/**
 * Class DirectdebitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class DirectdebitTest extends UnitTest
{
    /**
     * @var DirectdebitTransformer
     */
    protected $directdebitTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->directdebitTransformer = new DirectdebitTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->directdebitTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->directdebitTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'mandate' => [
                'id'          => 'IO-8284-8371-9550',
                'type'        => 'single',
                'serviceId'   => 'SL-5796-8370',
                'description' => 'Test directdebit',
                'processDate' => DateTime::createFromFormat('Y-m-d H:i:s', '2019-10-07 08:39:42'),
                'exchangeUrl' => 'https://www.pay.nl/exchange-url',
                'customer' => [
                    'ip' => '66.249.64.0',
                    'email' => 'somebody@somedomain.com',
                    'bankAccount' => [
                        'owner' => 'PAY.',
                        'bic' => 'RABONL2U',
                        'iban' => 'NL35RABO0117713678',
                    ],
                ],
                'amount' => [
                    'amount' => 100,
                    'currency' => 'EUR',
                ],
                'bankaccount' => [
                    'iban'  => 'NL00RABO0000000000',
                    'bic'   => 'RABONL2U',
                    'owner' => 'John Hancock'
                ],
                'interval' => [
                    'period' => 'Month',
                    'quantity' => 1,
                    'value' => 1,
                ],
                'statistics' => [
                    'promoterId' => 0,
                    'info' => 'test',
                    'tool' => 'some-tool',
                    'extra1' => '',
                    'extra2' => '',
                    'extra3' => '',
                    'transferData' => [
                        'data'
                    ],
                ],
                'isLastOrder' => false,
            ],
            'directdebits' => [
                [
                    'id'               => 'IL-1000-1000-1001',
                    'paymentSessionId' => '1149497187',
                    'amount'           => [
                        'amount'   => 20,
                        'currency' => 'EUR',
                    ],
                    'description'      => 'Test',
                    'bankAccount'      => [
                        'iban'  => 'NL00ABNA00000000',
                        'bic'   => 'ABNANL2A',
                        'owner' => 'J. the Hutt',
                    ],
                    'status'           => [
                        'code'   =>  94,
                        'name'   =>  'Verwerkt',
                        'date'   =>  null,
                        'reason' =>  '',
                    ],
                    'declined'         => null,
                ],
                [
                    'id'               => 'IL-1000-1000-1002',
                    'paymentSessionId' => '1149497187',
                    'amount'           => [
                        'amount'   => 80,
                        'currency' => 'EUR',
                    ],
                    'description'      => 'Test',
                    'bankAccount'      => [
                        'iban'  => 'NL00ABNA00000000',
                        'bic'   => 'ABNANL2A',
                        'owner' => 'J. the Hutt',
                    ],
                    'status'           => [
                        'code'   =>  94,
                        'name'   =>  'Verwerkt',
                        'date'   =>  null,
                        'reason' =>  '',
                    ],
                    'declined'         => null,
                ],
            ],
            '_links' => [
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'https://www.pay.nl'
                ]
            ]
        ]);

        $output = $this->directdebitTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('mandate');
        verify($output['mandate'])->isInstanceOf(Mandate::class);
        verify($output)->hasKey('directdebits');
        verify($output['directdebits'])->array();
        verify($output['directdebits'])->count(2);
        verify($output['directdebits'])->containsOnlyInstancesOf(Directdebit::class);
        verify($output)->hasKey('links');
        verify($output['links'])->isInstanceOf(Links::class);
        verify($output['links'])->count(1);
        verify($output['links'])->containsOnlyInstancesOf(Link::class);
    }
}
