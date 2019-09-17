<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Card;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class CardTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CardTest extends UnitTest
{
    /**
     * @var Card
     */
    protected $card;

    public function _before(): void
    {
        $this->card = new Card();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->card)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->card)->isNotInstanceOf(\JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->card->setId('1009'))->isInstanceOf(Card::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->card->setId('1009');

        verify($this->card->getId())->string();
        verify($this->card->getId())->notEmpty();
        verify($this->card->getId())->equals('1009');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->card->setName('Maestro'))->isInstanceOf(Card::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->card->setName('Maestro');

        verify($this->card->getName())->string();
        verify($this->card->getName())->notEmpty();
        verify($this->card->getName())->equals('Maestro');
    }
}
