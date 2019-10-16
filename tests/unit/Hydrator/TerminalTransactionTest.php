<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\TerminalTransaction as TerminalTransactionHydrator;
use PayNL\Sdk\Model\{
    Progress,
    Terminal,
    TerminalTransaction
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class TerminalTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class TerminalTransactionTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new TerminalTransactionHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptATerminalTransactionModel(): void
    {
        $hydrator = new TerminalTransactionHydrator();
        expect($hydrator->hydrate([], new TerminalTransaction()))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new TerminalTransactionHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new TerminalTransactionHydrator();
        $terminalTransaction = $hydrator->hydrate([
            'state'                 => 'approved',
            'terminalTransactionId' => 'TT-1000-0000-0001',
            'transactionHash'       => '000194280617b1106fa30fa88271c6a5c6fe235770696e34262b1099',
            'issuerUrl'             => 'https://www.pay.nl/issuer-url',
            'statusUrl'             => 'https://www.pay.nl/status-url',
            'cancelUrl'             => 'https://www.pay.nl/cancel-url',
            'nextUrl'               => 'https://www.pay.nl/next-url/2',
            'terminal'              => [
                'id'          => 'TT-0000-0000-0000',
                'name'        => 'Terminal New York #5.',
                'ecrProtocol' => 'WEB',
                'state'       => 'final'
            ],
            'progress'              => [
                'percentage'          => 100,
                'secondsPast'         => 120,
                'percentagePerSecond' => 100/120,
            ],
        ], new TerminalTransaction());

        expect($terminalTransaction->getState())->string();
        expect($terminalTransaction->getState())->equals('approved');
        expect($terminalTransaction->getTerminalTransactionId())->string();
        expect($terminalTransaction->getTerminalTransactionId())->equals('TT-1000-0000-0001');
        expect($terminalTransaction->getTransactionHash())->string();
        expect($terminalTransaction->getTransactionHash())->equals('000194280617b1106fa30fa88271c6a5c6fe235770696e34262b1099');
        expect($terminalTransaction->getIssuerUrl())->string();
        expect($terminalTransaction->getIssuerUrl())->equals('https://www.pay.nl/issuer-url');
        expect($terminalTransaction->getStatusUrl())->string();
        expect($terminalTransaction->getStatusUrl())->equals('https://www.pay.nl/status-url');
        expect($terminalTransaction->getCancelUrl())->string();
        expect($terminalTransaction->getCancelUrl())->equals('https://www.pay.nl/cancel-url');
        expect($terminalTransaction->getNextUrl())->string();
        expect($terminalTransaction->getNextUrl())->equals('https://www.pay.nl/next-url/2');
        expect($terminalTransaction->getTerminal())->isInstanceOf(Terminal::class);
        expect($terminalTransaction->getProgress())->isInstanceOf(Progress::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new TerminalTransactionHydrator();
        $terminalTransaction = $hydrator->hydrate([
            'state'                 => 'approved',
            'terminalTransactionId' => 'TT-1000-0000-0001',
            'transactionHash'       => '000194280617b1106fa30fa88271c6a5c6fe235770696e34262b1099',
            'issuerUrl'             => 'https://www.pay.nl/issuer-url',
            'statusUrl'             => 'https://www.pay.nl/status-url',
            'cancelUrl'             => 'https://www.pay.nl/cancel-url',
            'nextUrl'               => 'https://www.pay.nl/next-url/2',
            'terminal'              => [
                'id'          => 'TT-0000-0000-0000',
                'name'        => 'Terminal New York #5.',
                'ecrProtocol' => 'WEB',
                'state'       => 'final'
            ],
            'progress'              => [
                'percentage'          => 100,
                'secondsPast'         => 120,
                'percentagePerSecond' => 100/120,
            ],
        ], new TerminalTransaction());

        $data = $hydrator->extract($terminalTransaction);
        $this->assertIsArray($data);
        verify($data)->hasKey('state');
        verify($data)->hasKey('terminalTransactionId');
        verify($data)->hasKey('transactionHash');
        verify($data)->hasKey('issuerUrl');
        verify($data)->hasKey('statusUrl');
        verify($data)->hasKey('cancelUrl');
        verify($data)->hasKey('nextUrl');
        verify($data)->hasKey('terminal');
        verify($data)->hasKey('progress');

        expect($data['state'])->string();
        expect($data['state'])->equals('approved');
        expect($data['terminalTransactionId'])->string();
        expect($data['terminalTransactionId'])->equals('TT-1000-0000-0001');
        expect($data['transactionHash'])->string();
        expect($data['transactionHash'])->equals('000194280617b1106fa30fa88271c6a5c6fe235770696e34262b1099');
        expect($data['issuerUrl'])->string();
        expect($data['issuerUrl'])->equals('https://www.pay.nl/issuer-url');
        expect($data['statusUrl'])->string();
        expect($data['statusUrl'])->equals('https://www.pay.nl/status-url');
        expect($data['cancelUrl'])->string();
        expect($data['cancelUrl'])->equals('https://www.pay.nl/cancel-url');
        expect($data['nextUrl'])->string();
        expect($data['nextUrl'])->equals('https://www.pay.nl/next-url/2');
        expect($data['terminal'])->isInstanceOf(Terminal::class);
        expect($data['progress'])->isInstanceOf(Progress::class);
    }
}
