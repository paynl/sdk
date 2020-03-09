<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class TotalCollection
 *
 * @package PayNL\Sdk
 */
abstract class AbstractTotalCollection extends ArrayCollection implements CollectionInterface
{
    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @return integer
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return AbstractTotalCollection
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value): void
    {
        parent::set($key, $value);
        $this->setTotal($this->count());
    }

    /**
     * @inheritDoc
     */
    public function add($element): bool
    {
        $result =  parent::add($element);
        if (true === $result) {
            $this->setTotal($this->getTotal() + 1);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function remove($key)
    {
        $result = parent::remove($key);
        if (null !== $result) {
            $this->setTotal($this->getTotal() - 1);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function removeElement($element)
    {
        $result = parent::removeElement($element);
        if (true === $result) {
            $this->setTotal($this->getTotal() - 1);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        parent::clear();
        $this->setTotal(0);
    }
}
