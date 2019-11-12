<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    TerminalTransaction as TerminalTransactionTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\TerminalTransaction;

/**
 * Class TerminalTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class TerminalTransactionTest extends UnitTest
{
    /**
     * @var TerminalTransactionTransformer
     */
    protected $terminalTransactionTest;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->terminalTransactionTest = new TerminalTransactionTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->terminalTransactionTest)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->terminalTransactionTest)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformSingle(): void
    {
        $input = json_encode([
            'state'           => 'approved',
            'transactionId'   => 'TT-1000-0000-0001',
            'transactionHash' => '000194280617b1106fa30fa88271c6a5c6fe235770696e34262b1099',
            'issuerUrl'       => 'https://www.pay.nl/issuer-url',
            'statusUrl'       => 'https://www.pay.nl/status-url',
            'cancelUrl'       => 'https://www.pay.nl/cancel-url',
            'nextUrl'         => 'https://www.pay.nl/next-url/2',
            'terminal'        => [
                'id'          => 'TT-0000-0000-0000',
                'name'        => 'Terminal New York #5.',
                'ecrProtocol' => 'WEB',
                'state'       => 'final'
            ],
            'progress'        => [
                'percentage'          => 100,
                'secondsPast'         => 120,
                'percentagePerSecond' => 100/120,
            ],
        ]);

        $output = $this->terminalTransactionTest->transform($input);
        verify($output)->isInstanceOf(TerminalTransaction::class);
    }
}
