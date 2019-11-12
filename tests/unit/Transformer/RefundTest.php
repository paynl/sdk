<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Refund as RefundTransformer,
    TransformerInterface
};
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\Amount;
use PayNL\Sdk\Model\Refund;
use Exception;

/**
 * Class RefundTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class RefundTest extends UnitTest
{
    /**
     * @var RefundTransformer
     */
    protected $refundTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->refundTransformer = new RefundTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->refundTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->refundTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'paymentSessionId' => '9aa0943f-dade-11e9-96ef-90b11c281a75',
            'amount' => [
                'amount'   => 29.92,
                'currency' => 'EUR'
            ],
            'description' => '',
            'bankAccount' => [
                'iban'  => 'NL35RABO0117713678',
                'bic'   => 'RABONL2U',
                'owner' => 'PAY.',
            ],
            'status' => [
                'code' => 'collected',
                'name' => 'Cashed',
                'date' => DateTime::now(),
            ],
            'products' => [
                [
                    'id'          => 'b423e8a8-dade-11e9-96ef-90b11c281a75',
                    'description' => 'Test product',
                    'price'       => [
                        'amount'   => 14.96,
                        'currency' => 'EUR',
                    ],
                    'quantity'    => 2.00,
                    'vat'         => 259,
                ]
            ],
            'reason' => 'A specific reason',
            'processDate' => DateTime::now(),
        ]);

        $output = $this->refundTransformer->transform($input);
        verify($output)->isInstanceOf(Refund::class);
    }
}
