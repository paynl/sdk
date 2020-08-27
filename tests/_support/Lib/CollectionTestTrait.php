<?php

declare(strict_types=1);

namespace Codeception\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Common\{
    AbstractTotalCollection,
    CollectionInterface
};
use ArrayAccess,
    Countable,
    IteratorAggregate
;

/**
 * Trait CollectionTestTrait
 *
 * @package Codeception\Lib
 */
trait CollectionTestTrait
{
    /**
     * @var CollectionInterface
     */
    protected $model;

    /**
     * @var bool
     */
    protected $shouldItBeATotalCollection = false;

    /**
     * @return void
     */
    public function testItIsAnArrayCollection(): void
    {
        verify($this->model)->isInstanceOf(ArrayCollection::class);
    }

    /**
     * @depends testItIsAnArrayCollection
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->model)->isInstanceOf(Countable::class);
        verify([$this->model, 'count'])->callable();
        verify($this->model->count())->int();
        $containment = $this->model->getValues();
        verify($this->model->count())->equals(count($containment));
    }

    /**
     * @depends testItIsAnArrayCollection
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->model)->isInstanceOf(ArrayAccess::class);
        verify([$this->model, 'offsetExists'])->callable();
        verify([$this->model, 'offsetGet'])->callable();
        verify([$this->model, 'offsetSet'])->callable();
        verify([$this->model, 'offsetUnset'])->callable();
    }

    /**
     * @depends testItIsAnArrayCollection
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->model)->isInstanceOf(IteratorAggregate::class);
        verify(is_iterable($this->model))->true();
    }

    /**
     * @return void
     */
    public function testItIsACollection(): void
    {
        verify($this->model)->isInstanceOf(CollectionInterface::class);

        if (true === $this->shouldItBeATotalCollection) {
            verify($this->model)->isInstanceOf(AbstractTotalCollection::class);
        } else {
            verify($this->model)->isNotInstanceOf(AbstractTotalCollection::class);
        }
    }

    /**
     * @depends testItIsACollection
     *
     * @return void
     */
    public function testItCanGetCollectionName(): void
    {
        $collectionName = $this->model->getCollectionName();
        verify($collectionName)->string();
        verify($collectionName)->notEmpty();
    }

    /**
     * @return static
     */
    protected function markAsTotalCollection(): self
    {
        $this->shouldItBeATotalCollection = true;
        return $this;
    }
}
