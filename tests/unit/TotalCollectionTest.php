<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\TotalCollection;
use JsonSerializable, Countable;

/**
 * Class ConfigTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class TotalCollectionTest extends UnitTest
{
    /**
     * @var TotalCollection
     */
    protected $totalCollection;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->totalCollection = new TotalCollection();
    }

    /**
     * @return void
     */
    public function testItIsAnArrayCollection(): void
    {
        verify($this->totalCollection)->isInstanceOf(ArrayCollection::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->totalCollection)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetTotal(): void
    {
        verify(method_exists($this->totalCollection, 'setTotal'))->true();
        verify($this->totalCollection->setTotal(3))->isInstanceOf(TotalCollection::class);
    }

    /**
     * @depends testItCanSetTotal
     *
     * @return void
     */
    public function testItCanGetTotal(): void
    {
        verify(method_exists($this->totalCollection, 'getTotal'))->true();

        verify($this->totalCollection->getTotal())->int();
        verify($this->totalCollection->getTotal())->equals(0);

        $this->totalCollection->setTotal(3);

        verify($this->totalCollection->getTotal())->equals(3);
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     *
     * @return void
     */
    public function testItCanSet(): void
    {
        verify(method_exists($this->totalCollection, 'set'))->true();
        verify($this->totalCollection->getTotal())->equals(0);

        $this->totalCollection->set('key', 'value');

        verify($this->totalCollection->getTotal())->equals(1);
        verify($this->totalCollection)->hasKey('key');
        verify($this->totalCollection)->contains('value');
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     *
     * @return void
     */
    public function testItCanAdd(): void
    {
        verify(method_exists($this->totalCollection, 'add'))->true();
        verify($this->totalCollection->getTotal())->equals(0);

        $this->totalCollection->add('value');

        verify($this->totalCollection->getTotal())->equals(1);
        verify($this->totalCollection)->hasKey(0);
        verify($this->totalCollection)->contains('value');
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     * @depends testItCanSet
     *
     * @return void
     */
    public function testItCanRemove(): void
    {
        verify(method_exists($this->totalCollection, 'remove'))->true();
        verify($this->totalCollection->getTotal())->equals(0);

        $this->totalCollection->set('key', 'some-value');

        verify($this->totalCollection->getTotal())->equals(1);

        $this->totalCollection->remove('key');

        verify($this->totalCollection->getTotal())->equals(0);
        verify($this->totalCollection)->hasntKey('key');
        verify($this->totalCollection)->notContains('some-value');
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     * @depends testItCanAdd
     *
     * @return void
     */
    public function testItCanRemoveElement(): void
    {
        verify(method_exists($this->totalCollection, 'removeElement'))->true();

        verify($this->totalCollection->getTotal())->equals(0);

        $this->totalCollection->add('some-value');

        verify($this->totalCollection->getTotal())->equals(1);

        $this->totalCollection->removeElement('some-value');

        verify($this->totalCollection->getTotal())->equals(0);
        verify($this->totalCollection)->notContains('some-value');
    }


    /**
     * @depends testItCanAdd
     *
     * @return void
     */
    public function testItCanCount(): void
    {
        verify($this->totalCollection)->isInstanceOf(Countable::class);
        verify(method_exists($this->totalCollection, 'count'))->true();

        $this->totalCollection->add('some-value');

        verify($this->totalCollection->count())->equals(1);
        verify(count($this->totalCollection))->equals(1);

    }

    /**
     * @depends testItCanGetTotal
     * @depends testItCanCount
     * @depends testItCanAdd
     *
     * @return void
     */
    public function testItCountAndTotalAreEqual(): void
    {
        $this->totalCollection->add('Element-1');
        $this->totalCollection->add('Element-2');
        $this->totalCollection->add('Element-3');

        verify($this->totalCollection->getTotal())->equals($this->totalCollection->count());

        verify($this->totalCollection->getTotal())->equals(3);
        verify($this->totalCollection->count())->equals(3);
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     * @depends testItCanAdd
     *
     * @return void
     */
    public function testItCanClear(): void
    {
        verify(method_exists($this->totalCollection, 'clear'))->true();

        $this->totalCollection->add('some-value-1');
        $this->totalCollection->add('some-value-2');
        $this->totalCollection->add('some-value-3');

        verify($this->totalCollection->getTotal())->equals(3);

        $this->totalCollection->clear();

        verify($this->totalCollection->getTotal())->equals(0);
        verify($this->totalCollection)->isEmpty();
    }
}
