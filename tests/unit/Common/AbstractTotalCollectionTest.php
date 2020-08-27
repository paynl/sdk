<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Common\AbstractTotalCollection;
use PayNL\Sdk\Common\CollectionInterface;

class AbstractTotalCollectionTest extends UnitTest
{
    /**
     * @var AbstractTotalCollection
     */
    protected $totalCollection;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->totalCollection = new class() extends AbstractTotalCollection {
            /**
             * @inheritDoc
             */
            public function getCollectionName(): string
            {
                return 'foobar';
            }
        };
    }

    public function testItCanConstruct(): void
    {
        verify($this->totalCollection)->isInstanceOf(AbstractTotalCollection::class);
    }

    public function testItIsACollection(): void
    {
        verify($this->totalCollection)->isInstanceOf(ArrayCollection::class);
        verify($this->totalCollection)->isInstanceOf(CollectionInterface::class);
    }

    public function testItCanGetTotal(): void
    {
        $total = $this->totalCollection->getTotal();
        verify($total)->int();
        verify($total)->equals(0);
    }

    /**
     * @depends testItCanGetTotal
     *
     * @return void
     */
    public function testItCanSetTotal(): void
    {
        $this->totalCollection->setTotal(5);

        $total = $this->totalCollection->getTotal();
        verify($total)->equals(5);
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     *
     * @return void
     */
    public function testItCanSet(): void
    {
        verify($this->totalCollection)->isEmpty();

        $this->totalCollection->set('foo', 'bar');

        verify($this->totalCollection)->notEmpty();
        verify($this->totalCollection)->hasKey('foo');
        verify($this->totalCollection->get('foo'))->equals('bar');
        verify($this->totalCollection->getTotal())->equals(1);

        $this->totalCollection->set('foo', 'baz');
        verify($this->totalCollection)->notEmpty();
        verify($this->totalCollection)->hasKey('foo');
        verify($this->totalCollection->get('foo'))->equals('baz');
        verify($this->totalCollection->getTotal())->equals(1);
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     *
     * @return void
     */
    public function testItCanAdd(): void
    {
        verify($this->totalCollection)->isEmpty();

        $this->totalCollection->add('foo');

        verify($this->totalCollection)->notEmpty();
        verify($this->totalCollection)->contains('foo');
        verify($this->totalCollection->get(0))->equals('foo');
        verify($this->totalCollection->getTotal())->equals(1);

        $this->totalCollection->add('bar');

        verify($this->totalCollection)->notEmpty();
        verify($this->totalCollection)->contains('bar');
        verify($this->totalCollection->get(1))->equals('bar');
        verify($this->totalCollection->getTotal())->equals(2);

        $this->totalCollection->add('foo');

        verify($this->totalCollection)->notEmpty();
        verify($this->totalCollection)->contains('foo');
        verify($this->totalCollection->get(2))->equals('foo');
        verify($this->totalCollection->getTotal())->equals(3);
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     *
     * @return void
     */
    public function testItCanRemove(): void
    {
        $this->totalCollection->set('foo', 'bar');
        $this->totalCollection->add('baz');

        verify($this->totalCollection)->count(2);
        verify($this->totalCollection->getTotal())->equals(2);

        $item = $this->totalCollection->remove('non-existing-key');
        verify($item)->null();

        verify($this->totalCollection)->count(2);
        verify($this->totalCollection->getTotal())->equals(2);

        $item = $this->totalCollection->remove('foo');
        verify($item)->string();
        verify($item)->equals('bar');

        verify($this->totalCollection)->count(1);
        verify($this->totalCollection->getTotal())->equals(1);
    }

    /**
     * @depends testItCanSetTotal
     * @depends testItCanGetTotal
     *
     * @return void
     */
    public function testItCanRemoveElement(): void
    {
        $this->totalCollection->set('foo', 'bar');
        $this->totalCollection->add('baz');

        verify($this->totalCollection)->count(2);
        verify($this->totalCollection->getTotal())->equals(2);

        $result = $this->totalCollection->removeElement('non-existing-entry');
        verify($result)->false();

        verify($this->totalCollection)->count(2);
        verify($this->totalCollection->getTotal())->equals(2);

        $result = $this->totalCollection->removeElement('baz');
        verify($result)->true();

        verify($this->totalCollection)->count(1);
        verify($this->totalCollection->getTotal())->equals(1);
    }

    /**
     * @depends testItCanSetTotal
     *
     * @return void
     */
    public function testItCanClear(): void
    {
        $this->totalCollection->set('foo', 'bar');
        $this->totalCollection->add('baz');

        verify($this->totalCollection)->count(2);
        verify($this->totalCollection->getTotal())->equals(2);

        $this->totalCollection->clear();

        verify($this->totalCollection)->count(0);
        verify($this->totalCollection->getTotal())->equals(0);
    }
}
