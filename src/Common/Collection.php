<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection
{
    protected $collectionKey;

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return $this->collectionKey;
    }

    /**
     * @param string $collectionKey
     *
     * @return Collection
     */
    protected function setCollectionKey(string $collectionKey): self
    {
        $this->collectionKey = $collectionKey;
        return $this;
    }
}
