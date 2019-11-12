<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Countable, ArrayAccess, IteratorAggregate, ArrayIterator;

/**
 * Class Links
 *
 * @package PayNL\Sdk\Model
 */
class Links implements ModelInterface, Countable, ArrayAccess, IteratorAggregate
{
    /**
     * @var array
     */
    protected $links = [];

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     *
     * @return Links
     */
    public function setLinks(array $links): self
    {
        if (0 === count($links)) {
            return $this;
        }

        foreach ($links as $link) {
            $this->addLink($link);
        }
        return $this;
    }

    /**
     * @param Link $link
     *
     * @return Links
     */
    public function addLink(Link $link): self
    {
        $this->links[$link->getRel()] = $link;
        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->links);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->links[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->links[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->addLink($value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->links[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->links);
    }
}
