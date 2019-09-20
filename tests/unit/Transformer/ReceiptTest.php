<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Receipt as ReceiptTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\{
    Receipt,
    Card,
    PaymentMethod
};

/**
 * Class ReceiptTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class ReceiptTest extends UnitTest
{
    /**
     * @var ReceiptTransformer
     */
    protected $receiptTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->receiptTransformer = new ReceiptTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->receiptTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->receiptTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'id' => 'TG9yZW0lMjBpcHN1bSUyMGRvbG9yJTIwc2l0JTIwYW1ldCwlMjBjb25zZWN0ZXR1ciUyMGFkaXBpc2NpbmclMjBlbGl0Lg==',
            'signature' => 'f0c652f5-db83-11e9-96ef-90b11c281a75',
            'approvalId' => 'f61cd411-db83-11e9-96ef-90b11c281a75',
            'card' => [
                'id' => '1009',
                'name' => 'Maestro',
            ],
            'paymentMethod' => [
                'id' => '10',
                'name' => 'iDeal',
//                'settings' => [],
            ],
        ]);

        $output = $this->receiptTransformer->transform($input);
        verify($output)->isInstanceOf(Receipt::class);
        verify($output->getCard())->isInstanceOf(Card::class);
        verify($output->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
    }
}
