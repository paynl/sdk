<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Terminal
};
use JsonSerializable;

/**
 * Class TerminalTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TerminalTest extends UnitTest
{
    /**
     * @var Terminal
     */
    protected $terminal;

    public function _before(): void
    {
        $this->terminal = new Terminal();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->terminal)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->terminal)->isInstanceOf(JsonSerializable::class);

        verify($this->terminal->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->terminal->setId('T-0000'))->isInstanceOf(Terminal::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->terminal->setId('T-0000');

        verify($this->terminal->getId())->string();
        verify($this->terminal->getId())->notEmpty();
        verify($this->terminal->getId())->equals('T-0000');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->terminal->setName('Terminal #5'))->isInstanceOf(Terminal::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->terminal->setName('Terminal #5');

        verify($this->terminal->getName())->string();
        verify($this->terminal->getName())->notEmpty();
        verify($this->terminal->getName())->equals('Terminal #5');
    }

    /**
     * @return void
     */
    public function testItCanSetAEcrProtocol(): void
    {
        expect($this->terminal->setEcrProtocol('WEB'))->isInstanceOf(Terminal::class);
    }

    /**
     * @depends testItCanSetAEcrProtocol
     *
     * @return void
     */
    public function testItCanGetAEcrProtocol(): void
    {
        $this->terminal->setEcrProtocol('WEB');

        verify($this->terminal->getEcrProtocol())->string();
        verify($this->terminal->getEcrProtocol())->notEmpty();
        verify($this->terminal->getEcrProtocol())->equals('WEB');
    }

    /**
     * @return void
     */
    public function testItCanSetAState(): void
    {
        expect($this->terminal->setState('active'))->isInstanceOf(Terminal::class);
    }

    /**
     * @depends testItCanSetAState
     *
     * @return void
     */
    public function testItCanGetAState(): void
    {
        $this->terminal->setState('active');

        verify($this->terminal->getState())->string();
        verify($this->terminal->getState())->notEmpty();
        verify($this->terminal->getState())->equals('active');
    }
}
