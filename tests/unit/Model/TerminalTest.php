<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Exception\InvalidServiceException;
use PayNL\Sdk\Model\Terminal;

/**
 * Class TerminalTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TerminalTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Terminal
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Terminal();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        expect($this->model->setId('T-0000'))->isInstanceOf(Terminal::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $this->model->setId('T-0000');

        verify($this->model->getId())->string();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals('T-0000');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('Terminal #5'))->isInstanceOf(Terminal::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $this->model->setName('Terminal #5');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('Terminal #5');
    }

    /**
     * @return void
     */
    public function testItCanSetAEcrProtocol(): void
    {
        $this->tester->assertObjectHasMethod('setEcrProtocol', $this->model);
        $this->tester->assertObjectMethodIsPublic('setEcrProtocol', $this->model);

        expect($this->model->setEcrProtocol('WEB'))->isInstanceOf(Terminal::class);
    }

    /**
     * @depends testItCanSetAEcrProtocol
     *
     * @return void
     */
    public function testItCanGetAEcrProtocol(): void
    {
        $this->tester->assertObjectHasMethod('getEcrProtocol', $this->model);
        $this->tester->assertObjectMethodIsPublic('getEcrProtocol', $this->model);

        $this->model->setEcrProtocol('WEB');

        verify($this->model->getEcrProtocol())->string();
        verify($this->model->getEcrProtocol())->notEmpty();
        verify($this->model->getEcrProtocol())->equals('WEB');
    }

    /**
     * @return void
     */
    public function testItCanSetAState(): void
    {
        $this->tester->assertObjectHasMethod('setState', $this->model);
        $this->tester->assertObjectMethodIsPublic('setState', $this->model);

        expect($this->model->setState('active'))->isInstanceOf(Terminal::class);
    }

    public function testItThrowsAnExceptionSettingInvalidState(): void
    {
        $state = 'foo';
        $this->assertArrayNotHasKey($state, array_flip($this->model::STATES));
        $this->expectException(InvalidServiceException::class);
        $this->model->setState($state);
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
}
