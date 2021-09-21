<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Member\LinksAwareTrait,
    Terminal,
    Terminals
};
use TypeError;

/**
 * Class TerminalsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TerminalsTest extends UnitTest
{
    use ModelTestTrait;
    use CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
        testItCanGetCollectionName as traitTestItCanGetCollectionName;
    }

    /**
     * @var Terminals
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsTotalCollection();
        $this->model = new Terminals();
    }

    /**
     * @return void
     */
    public function testItIsLinksAware(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksAwareTrait::class);
    }

    /**
     * @param string $id
     *
     * @return Terminal
     */
    private function getMockTerminal(string $id): Terminal
    {
        /** @var Terminal $terminal */
        $terminal = $this->tester->grabService('modelManager')->build(Terminal::class);
        $terminal->setId($id);
        return $terminal;
    }

    /**
     * @return void
     */
    public function testItCanAddTerminal(): void
    {
        $this->tester->assertObjectHasMethod('addTerminal', $this->model);
        $this->tester->assertObjectMethodIsPublic('addTerminal', $this->model);

        $mockTerminal = $this->getMockTerminal('foo');

        $terminals = $this->model->addTerminal($mockTerminal);
        verify($terminals)->object();
        verify($terminals)->same($this->model);
        verify($terminals)->hasKey($mockTerminal->getId());
    }

    /**
     * @depends testItCanAddTerminal
     *
     * @return void
     */
    public function testItCanSetTerminals(): void
    {
        $this->tester->assertObjectHasMethod('setTerminals', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTerminals', $this->model);

        $mockTerminal = $this->getMockTerminal('foo');

        $terminals = $this->model->setTerminals([$mockTerminal]);
        verify($terminals)->object();
        verify($terminals)->same($this->model);
        verify($terminals)->containsOnlyInstancesOf(Terminal::class);
        verify($terminals)->notEmpty();
        verify($terminals)->count(1);

        $terminals = $this->model->setTerminals([
            $this->getMockTerminal('bar'),
            $this->getMockTerminal('baz'),
        ]);
        verify($terminals)->object();
        verify($terminals)->same($this->model);
        verify($terminals)->containsOnlyInstancesOf(Terminal::class);
        verify($terminals)->count(2);
        verify($terminals)->notContains($mockTerminal);
    }

    /**
     * @depends testItCanAddTerminal
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testSetTerminalsThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setTerminals([$this->getMockTerminal('foo'), []]);
    }

    /**
     * @depends testItCanAddTerminal
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testItCanSetEmptyTerminals(): void
    {
        $links = $this->model->setTerminals([]);
        verify($links)->isInstanceOf(Terminals::class);
        verify($links)->same($this->model);
        verify($links)->count(0);
    }

    /**
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testItCanGetTerminals(): void
    {
        $this->tester->assertObjectHasMethod('getTerminals', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTerminals', $this->model);

        $terminal = $this->getMockTerminal('foo');

        $this->model->setTerminals([$terminal]);
        $terminals = $this->model->getTerminals();
        verify($terminals)->array();
        verify($terminals)->count(1);
        verify($terminals)->hasKey('foo');
        verify($terminals)->containsOnlyInstancesOf(Terminal::class);
    }

    /**
     * @depends testItCanSetTerminals
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model->setTerminals([ $this->getMockTerminal('foo') ]);

        // offsetExists
        verify(isset($this->model['foo']))->true();
        verify(isset($this->model['bar']))->false();

        // offsetGet
        verify($this->model['foo'])->isInstanceOf(Terminal::class);

        // offsetSet
        $this->model['baz'] = $this->getMockTerminal('baz');
        verify($this->model)->hasKey('baz');
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model['foo']);
        verify($this->model)->count(1);
        verify($this->model)->hasNotKey('foo');
    }

    /**
     * @inheritDoc
     */
    public function testItCanGetCollectionName(): void
    {
        $this->traitTestItCanGetCollectionName();
        verify($this->model->getCollectionName())->equals('terminals');
    }
}
