<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Common\AbstractTotalCollection;

/**
 * Class Terminals
 *
 * @package PayNL\Sdk\Model
 */
class Terminals extends AbstractTotalCollection implements ModelInterface
{
    use LinksTrait;

    /**
     * @return array
     */
    public function getTerminals(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $terminals
     *
     * @return Terminals
     */
    public function setTerminals(array $terminals): self
    {
        // reset the total
        $this->clear();

        if (0 === count($terminals)) {
            return $this;
        }

        foreach ($terminals as $terminal) {
            $this->addTerminal($terminal);
        }

        return $this;
    }

    /**
     * @param Terminal $terminal
     *
     * @return Terminals
     */
    public function addTerminal(Terminal $terminal): self
    {
        $this->set($terminal->getId(), $terminal);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCollectionName(): string
    {
        return 'terminals';
    }
}
