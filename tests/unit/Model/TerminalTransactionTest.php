<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{ModelInterface, Progress, Terminal, TerminalTransaction};
use JsonSerializable;

/**
 * Class TerminalTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TerminalTransactionTest extends UnitTest
{
    /**
     * @var TerminalTransaction
     */
    protected $terminalTransaction;

    public function _before(): void
    {
        $this->terminalTransaction = new TerminalTransaction();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->terminalTransaction)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->terminalTransaction)->isInstanceOf(\JsonSerializable::class);

        verify($this->terminalTransaction->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAState(): void
    {
        expect($this->terminalTransaction->setState('active'))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetAState
     *
     * @return void
     */
    public function testItCanGetAState(): void
    {
        $this->terminalTransaction->setState('active');

        verify($this->terminalTransaction->getState())->string();
        verify($this->terminalTransaction->getState())->notEmpty();
        verify($this->terminalTransaction->getState())->equals('active');
    }

    /**
     * @return void
     */
    public function testItCanSetATransactionId(): void
    {
        expect($this->terminalTransaction->setTransactionId('TT-0000-0000'))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetATransactionId
     *
     * @return void
     */
    public function testItCanGetATransactionId(): void
    {
        $this->terminalTransaction->setTransactionId('TT-0000-0000');

        verify($this->terminalTransaction->getTransactionId())->string();
        verify($this->terminalTransaction->getTransactionId())->notEmpty();
        verify($this->terminalTransaction->getTransactionId())->equals('TT-0000-0000');
    }

    /**
     * @return void
     */
    public function testItCanSetATransactionHash(): void
    {
        expect($this->terminalTransaction->setTransactionHash('spec-hash'))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetATransactionHash
     *
     * @return void
     */
    public function testItCanGetATransactionHash(): void
    {
        $this->terminalTransaction->setTransactionHash('spec-hash');

        verify($this->terminalTransaction->getTransactionHash())->string();
        verify($this->terminalTransaction->getTransactionHash())->notEmpty();
        verify($this->terminalTransaction->getTransactionHash())->equals('spec-hash');
    }

    /**
     * @return void
     */
    public function testItCanSetAIssuerUrl(): void
    {
        expect($this->terminalTransaction->setIssuerUrl('https://www.pay.nl/issuer-url'))
            ->isInstanceOf(TerminalTransaction::class)
        ;
    }

    /**
     * @depends testItCanSetAIssuerUrl
     *
     * @return void
     */
    public function testItCanGetAIssuerUrl(): void
    {
        $this->terminalTransaction->setIssuerUrl('https://www.pay.nl/issuer-url');

        verify($this->terminalTransaction->getIssuerUrl())->string();
        verify($this->terminalTransaction->getIssuerUrl())->notEmpty();
        verify($this->terminalTransaction->getIssuerUrl())->equals('https://www.pay.nl/issuer-url');
    }

    /**
     * @return void
     */
    public function testItCanSetAStatusUrl(): void
    {
        expect($this->terminalTransaction->setStatusUrl('https://www.pay.nl/status-url'))
            ->isInstanceOf(TerminalTransaction::class)
        ;
    }

    /**
     * @depends testItCanSetAStatusUrl
     *
     * @return void
     */
    public function testItCanGetAStatusUrl(): void
    {
        $this->terminalTransaction->setStatusUrl('https://www.pay.nl/status-url');

        verify($this->terminalTransaction->getStatusUrl())->string();
        verify($this->terminalTransaction->getStatusUrl())->notEmpty();
        verify($this->terminalTransaction->getStatusUrl())->equals('https://www.pay.nl/status-url');
    }

    /**
     * @return void
     */
    public function testItCanSetACancelUrl(): void
    {
        expect($this->terminalTransaction->setCancelUrl('https://www.pay.nl/cancel-url'))
            ->isInstanceOf(TerminalTransaction::class)
        ;
    }

    /**
     * @depends testItCanSetACancelUrl
     *
     * @return void
     */
    public function testItCanGetACancelUrl(): void
    {
        $this->terminalTransaction->setCancelUrl('https://www.pay.nl/cancel-url');

        verify($this->terminalTransaction->getCancelUrl())->string();
        verify($this->terminalTransaction->getCancelUrl())->notEmpty();
        verify($this->terminalTransaction->getCancelUrl())->equals('https://www.pay.nl/cancel-url');
    }

    /**
     * @return void
     */
    public function testItCanSetANextUrl(): void
    {
        expect($this->terminalTransaction->setNextUrl('https://www.pay.nl/next-url'))
            ->isInstanceOf(TerminalTransaction::class)
        ;
    }

    /**
     * @depends testItCanSetANextUrl
     *
     * @return void
     */
    public function testItCanGetANextUrl(): void
    {
        $this->terminalTransaction->setNextUrl('https://www.pay.nl/next-url');

        verify($this->terminalTransaction->getNextUrl())->string();
        verify($this->terminalTransaction->getNextUrl())->notEmpty();
        verify($this->terminalTransaction->getNextUrl())->equals('https://www.pay.nl/next-url');
    }

    /**
     * @return void
     */
    public function testItCanSetATerminal(): void
    {
        expect($this->terminalTransaction->setTerminal(new Terminal()))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetATerminal
     *
     * @return void
     */
    public function testItCanGetATerminal(): void
    {
        $this->terminalTransaction->setTerminal(new Terminal());

        verify($this->terminalTransaction->getTerminal())->notEmpty();
        verify($this->terminalTransaction->getTerminal())->isInstanceOf(Terminal::class);
    }

    /**
     * @return void
     */
    public function testItCanSetProgress(): void
    {
        expect($this->terminalTransaction->setProgress(new Progress()))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetProgress
     *
     * @return void
     */
    public function testItCanGetProgress(): void
    {
        $this->terminalTransaction->setProgress(new Progress());

        verify($this->terminalTransaction->getProgress())->notEmpty();
        verify($this->terminalTransaction->getProgress())->isInstanceOf(Progress::class);
    }
}
