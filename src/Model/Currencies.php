<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Common\TotalCollection;

/**
 * Class Currencies
 *
 * @package PayNL\Sdk\Model
 */
class Currencies extends TotalCollection implements ModelInterface
{
    use LinksTrait;

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $currencies
     *
     * @return Currencies
     */
    public function setCurrencies(array $currencies): self
    {
        // reset the total
        $this->clear();

        if (0 === count($currencies)) {
            return $this;
        }

        foreach ($currencies as $currency) {
            $this->addCurrency($currency);
        }

        return $this;
    }

    /**
     * @param Currency $currency
     *
     * @return Currencies
     */
    public function addCurrency(Currency $currency): self
    {
        $this->set($currency->getAbbreviation(), $currency);
        return $this;
    }

    public function getCollectionName(): string
    {
        return 'currencies';
    }
}
