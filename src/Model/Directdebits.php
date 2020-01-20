<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Directdebits
 *
 * @package PayNL\Sdk\Model
 */
class Directdebits implements ModelInterface
{
    use LinksTrait;

    /**
     * @var Mandate
     */
    protected $mandate;

    /**
     * @var array
     */
    protected $directdebits = [];

    /**
     * @return Mandate
     */
    public function getMandate(): Mandate
    {
        return $this->mandate;
    }

    /**
     * @param Mandate $mandate
     *
     * @return Directdebits
     */
    public function setMandate(Mandate $mandate): self
    {
        $this->mandate = $mandate;
        return $this;
    }

    /**
     * @return array
     */
    public function getDirectdebits(): array
    {
        return $this->directdebits;
    }

    /**
     * @param array $directdebits
     *
     * @return Directdebits
     */
    public function setDirectdebits(array $directdebits): self
    {
        $this->directdebits = [];
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
        $this->directdebits[] = $directdebit;
        return $this;
    }
}
