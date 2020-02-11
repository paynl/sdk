<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Directdebits
 *
 * @package PayNL\Sdk\Model
 */
class DirectdebitOverview implements ModelInterface
{
    use LinksTrait;

    /**
     * @var Mandate
     */
    protected $mandate;

    /**
     * @var Directdebits
     */
    protected $directdebits;

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
     * @return DirectdebitOverview
     */
    public function setMandate(Mandate $mandate): self
    {
        $this->mandate = $mandate;
        return $this;
    }

    /**
     * @return Directdebits
     */
    public function getDirectdebits(): Directdebits
    {
        return $this->directdebits;
    }

    /**
     * @param Directdebits $directdebits
     *
     * @return DirectdebitOverview
     */
    public function setDirectdebits(Directdebits $directdebits): self
    {
        $this->directdebits = $directdebits;
        return $this;
    }
}
