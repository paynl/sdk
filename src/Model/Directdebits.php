<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Directdebits
 *
 * @package PayNL\Sdk\Model
 */
class Directdebits extends ArrayCollection implements ModelInterface
{
    /**
     * @return array
     */
    public function getDirectdebits(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $directdebits
     *
     * @return Directdebits
     */
    public function setDirectdebits(array $directdebits): self
    {
        // reset the total
        $this->clear();

        if (0 === count($directdebits)) {
            return $this;
        }

        foreach ($directdebits as $directdebit) {
            $this->addDirectdebit($directdebit);
        }

        return $this;
    }

    /**
     * @param Directdebit $directdebit
     *
     * @return Directdebits
     */
    public function addDirectdebit(Directdebit $directdebit): self
    {
        $this->set($directdebit->getId(), $directdebit);
        return $this;
    }

    public function getCollectionName(): string
    {
        return 'directdebits';
    }
}
