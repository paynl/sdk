<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Qr as QrTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\Qr;

/**
 * Class QrTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class QrTest extends UnitTest
{
    /**
     * @var QrTransformer
     */
    protected $qrTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->qrTransformer = new QrTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->qrTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->qrTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'uuid'          => '441d88c9-e8da-11e9-96ef-90b11c281a75',
            'serviceId'     => 'SL-1000-0001',
            'secret'        => 'abcdef0123456789abcdef0123456789abcd0123',
            'reference'     => 'ABCD1234',
            'padChar'       => '0',
            'referenceType' => 'string',
            'paymentMethod' => [
                'id'   => 10,
                'name' => 'iDeal',
            ],
        ]);

        $output = $this->qrTransformer->transform($input);
        verify($output)->isInstanceOf(Qr::class);
    }
}
