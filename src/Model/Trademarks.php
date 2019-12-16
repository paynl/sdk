<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Trademarks
 *
 * @package PayNL\Sdk\Model
 */
class Trademarks extends ArrayCollection implements ModelInterface
{
    /**
     * @return array
     */
    public function getTrademarks(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $trademarks
     *
     * @return Trademarks
     */
    public function setTrademarks(array $trademarks): self
    {
        $this->clear();

        if (0 === count($trademarks)) {
            return $this;
        }

        foreach ($trademarks as $trademark) {
            $this->addTrademark($trademark);
        }

        return $this;
    }

    /**
     * @param Trademark $trademark
     *
     * @return Trademarks
     */
    public function addTrademark(Trademark $trademark): self
    {
        $this->set($trademark->getId(), $trademark);
        return $this;
    }
}
