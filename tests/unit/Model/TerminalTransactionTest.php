<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Progress,
    Terminal,
    TerminalTransaction
};

/**
 * Class TerminalTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TerminalTransactionTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var TerminalTransaction
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new TerminalTransaction();
    }

    /**
     * @return void
     */
    public function testItCanSetAState(): void
    {
        $this->tester->assertObjectHasMethod('setState', $this->model);
        $this->tester->assertObjectMethodIsPublic('setState', $this->model);

        expect($this->model->setState('active'))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetAState
     *
     * @return void
     */
    public function testItCanGetAState(): void
    {
        $this->tester->assertObjectHasMethod('getState', $this->model);
        $this->tester->assertObjectMethodIsPublic('getState', $this->model);

        $this->model->setState('active');

        verify($this->model->getState())->string();
        verify($this->model->getState())->notEmpty();
        verify($this->model->getState())->equals('active');
    }

    /**
     * @return void
     */
    public function testItCanSetATransactionId(): void
    {
        $this->tester->assertObjectHasMethod('setTerminalTransactionId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTerminalTransactionId', $this->model);

        expect($this->model->setTerminalTransactionId('TT-0000-0000'))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetATransactionId
     *
     * @return void
     */
    public function testItCanGetATransactionId(): void
    {
        $this->tester->assertObjectHasMethod('getTerminalTransactionId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTerminalTransactionId', $this->model);

        $this->model->setTerminalTransactionId('TT-0000-0000');

        verify($this->model->getTerminalTransactionId())->string();
        verify($this->model->getTerminalTransactionId())->notEmpty();
        verify($this->model->getTerminalTransactionId())->equals('TT-0000-0000');
    }

    /**
     * @return void
     */
    public function testItCanSetATransactionHash(): void
    {
        $this->tester->assertObjectHasMethod('setTransactionHash', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTransactionHash', $this->model);

        expect($this->model->setTransactionHash('spec-hash'))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetATransactionHash
     *
     * @return void
     */
    public function testItCanGetATransactionHash(): void
    {
        $this->tester->assertObjectHasMethod('getTransactionHash', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTransactionHash', $this->model);

        $this->model->setTransactionHash('spec-hash');

        verify($this->model->getTransactionHash())->string();
        verify($this->model->getTransactionHash())->notEmpty();
        verify($this->model->getTransactionHash())->equals('spec-hash');
    }

    /**
     * @return void
     */
    public function testItCanSetAIssuerUrl(): void
    {
        $this->tester->assertObjectHasMethod('setIssuerUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setIssuerUrl', $this->model);

        expect($this->model->setIssuerUrl('https://www.pay.nl/issuer-url'))
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
        $this->tester->assertObjectHasMethod('getIssuerUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getIssuerUrl', $this->model);

        $this->model->setIssuerUrl('https://www.pay.nl/issuer-url');

        verify($this->model->getIssuerUrl())->string();
        verify($this->model->getIssuerUrl())->notEmpty();
        verify($this->model->getIssuerUrl())->equals('https://www.pay.nl/issuer-url');
    }

    /**
     * @return void
     */
    public function testItCanSetAStatusUrl(): void
    {
        $this->tester->assertObjectHasMethod('setStatusUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStatusUrl', $this->model);

        expect($this->model->setStatusUrl('https://www.pay.nl/status-url'))
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
        $this->tester->assertObjectHasMethod('getStatusUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStatusUrl', $this->model);

        $this->model->setStatusUrl('https://www.pay.nl/status-url');

        verify($this->model->getStatusUrl())->string();
        verify($this->model->getStatusUrl())->notEmpty();
        verify($this->model->getStatusUrl())->equals('https://www.pay.nl/status-url');
    }

    /**
     * @return void
     */
    public function testItCanSetACancelUrl(): void
    {
        $this->tester->assertObjectHasMethod('setCancelUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCancelUrl', $this->model);

        expect($this->model->setCancelUrl('https://www.pay.nl/cancel-url'))
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
        $this->tester->assertObjectHasMethod('getCancelUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCancelUrl', $this->model);

        $this->model->setCancelUrl('https://www.pay.nl/cancel-url');

        verify($this->model->getCancelUrl())->string();
        verify($this->model->getCancelUrl())->notEmpty();
        verify($this->model->getCancelUrl())->equals('https://www.pay.nl/cancel-url');
    }

    /**
     * @return void
     */
    public function testItCanSetANextUrl(): void
    {
        $this->tester->assertObjectHasMethod('setNextUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setNextUrl', $this->model);

        expect($this->model->setNextUrl('https://www.pay.nl/next-url'))
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
        $this->tester->assertObjectHasMethod('getNextUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getNextUrl', $this->model);

        $this->model->setNextUrl('https://www.pay.nl/next-url');

        verify($this->model->getNextUrl())->string();
        verify($this->model->getNextUrl())->notEmpty();
        verify($this->model->getNextUrl())->equals('https://www.pay.nl/next-url');
    }

    /**
     * @return void
     */
    public function testItCanSetATerminal(): void
    {
        $this->tester->assertObjectHasMethod('setTerminal', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTerminal', $this->model);

        expect($this->model->setTerminal(new Terminal()))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetATerminal
     *
     * @return void
     */
    public function testItCanGetATerminal(): void
    {
        $this->tester->assertObjectHasMethod('getTerminal', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTerminal', $this->model);

        $terminal = $this->model->getTerminal();
        verify($terminal)->isInstanceOf(Terminal::class);

        $this->model->setTerminal(new Terminal());

        verify($this->model->getTerminal())->notEmpty();
        verify($this->model->getTerminal())->isInstanceOf(Terminal::class);
        verify($this->model->getTerminal())->notSame($terminal);
    }

    /**
     * @return void
     */
    public function testItCanSetProgress(): void
    {
        $this->tester->assertObjectHasMethod('setProgress', $this->model);
        $this->tester->assertObjectMethodIsPublic('setProgress', $this->model);

        expect($this->model->setProgress(new Progress()))->isInstanceOf(TerminalTransaction::class);
    }

    /**
     * @depends testItCanSetProgress
     *
     * @return void
     */
    public function testItCanGetProgress(): void
    {
        $this->tester->assertObjectHasMethod('getProgress', $this->model);
        $this->tester->assertObjectMethodIsPublic('getProgress', $this->model);

        $progress = $this->model->getProgress();
        verify($progress)->isInstanceOf(Progress::class);

        $this->model->setProgress(new Progress());

        verify($this->model->getProgress())->notEmpty();
        verify($this->model->getProgress())->isInstanceOf(Progress::class);
        verify($this->model->getProgress())->notSame($progress);
    }
}
