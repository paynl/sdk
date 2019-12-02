<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\TotalCollection;
use PayNL\Sdk\Model\{
    ModelInterface,
    Links,
    Terminal,
    Terminals
};
use PayNL\Sdk\Hydrator\{
    Terminal as TerminalHydrator,
    Links as LinksHydrator
};
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate;

/**
 * Class TerminalsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TerminalsTest extends UnitTest
{
    /**
     * @var Terminals
     */
    protected $terminals;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->terminals = new Terminals();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->terminals)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsATotalCollection(): void
    {
        verify($this->terminals)->isInstanceOf(TotalCollection::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->terminals)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->terminals, 'setLinks'))->true();
        verify($this->terminals->setLinks(new Links()))->isInstanceOf(Terminals::class);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->terminals, 'getLinks'))->true();

        $this->terminals->setLinks(
            (new LinksHydrator())->hydrate([
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'http://some.url.com',
                ],
            ], new Links())
        );

        verify($this->terminals->getLinks())->isInstanceOf(Links::class);
        verify($this->terminals->getLinks())->count(1);
        verify($this->terminals->getLinks())->hasKey('self');
    }

    /**
     * @return void
     */
    public function testItCanAddTerminal(): void
    {
        verify(method_exists($this->terminals, 'addTerminal'))->true();
        verify($this->terminals->addTerminal((new TerminalHydrator())->hydrate([
            'id'          => 'TT-0000-0000',
            'name'        => 'Test terminal',
            'ecrProtocol' => 'WEB',
            'state'       => 'active',
        ], new Terminal())))->isInstanceOf(Terminals::class);
    }

    /**
     * @depends testItCanAddTerminal
     *
     * @return void
     */
    public function testItCanSetTerminals(): void
    {
        verify(method_exists($this->terminals, 'setTerminals'))->true();
        verify($this->terminals->setTerminals([]))->isInstanceOf(Terminals::class);
    }

    /**
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testItCanGetTerminals(): void
    {
        verify(method_exists($this->terminals, 'getTerminals'))->true();

        $this->terminals->setTerminals([
            (new TerminalHydrator())->hydrate([
                'id'          => 'TT-0000-0000',
                'name'        => 'Test terminal',
                'ecrProtocol' => 'WEB',
                'state'       => 'active',
            ], new Terminal()),
        ]);

        verify($this->terminals->getTerminals())->array();
        verify($this->terminals->getTerminals())->count(1);
    }

    /**
     * @return void
     */
    public function testItCanSetTotal(): void
    {
        verify(method_exists($this->terminals, 'setTotal'))->true();
        verify($this->terminals->setTotal(1))->isInstanceOf(Terminals::class);
    }

    /**
     * @depends testItCanSetTotal
     *
     * @return void
     */
    public function testItCanGetTotal(): void
    {
        verify(method_exists($this->terminals, 'getTotal'))->true();

        $this->terminals->setTotal(1);

        verify($this->terminals->getTotal())->int();
        verify($this->terminals->getTotal())->notEmpty();
        verify($this->terminals->getTotal())->equals(1);
    }


    /**
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->terminals)->isInstanceOf(Countable::class);

        $this->terminals->setTerminals([
            (new TerminalHydrator())->hydrate([
                'id'          => 'TT-0000-0000',
                'name'        => 'Test terminal',
                'ecrProtocol' => 'WEB',
                'state'       => 'active',
            ], new Terminal()),
        ])->setTotal(1);

        verify(count($this->terminals))->equals(1);
    }

    /**
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->terminals)->isInstanceOf(ArrayAccess::class);

        $this->terminals->setTerminals([
            (new TerminalHydrator())->hydrate([
                'id'          => 'TT-0000-0000',
                'name'        => 'Test terminal',
                'ecrProtocol' => 'WEB',
                'state'       => 'active',
            ], new Terminal()),
        ])->setTotal(1);

        // offsetExists
        verify(isset($this->terminals['TT-0000-0000']))->true();
        verify(isset($this->terminals['non_existing_key']))->false();

        // offsetGet
        verify($this->terminals['TT-0000-0000'])->isInstanceOf(Terminal::class);

        // offsetSet
        $this->terminals['TT-0000-0001'] = (new TerminalHydrator())->hydrate([
            'id'          => 'TT-0000-0001',
            'name'        => 'Test terminal',
            'ecrProtocol' => 'WEB',
            'state'       => 'active',
        ], new Terminal());
        verify($this->terminals)->hasKey('TT-0000-0001');
        verify($this->terminals)->count(2);

        // offsetUnset
        unset($this->terminals['TT-0000-0000']);
        verify($this->terminals)->count(1);
        verify($this->terminals)->hasntKey('TT-0000-0000');
    }

    /**
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->terminals)->isInstanceOf(IteratorAggregate::class);

        $this->terminals->setTerminals([
            (new TerminalHydrator())->hydrate([
                'id'          => 'TT-0000-0000',
                'name'        => 'Test terminal',
                'ecrProtocol' => 'WEB',
                'state'       => 'active',
            ], new Terminal()),
        ])->setTotal(1);

        verify(is_iterable($this->terminals))->true();
    }
}
