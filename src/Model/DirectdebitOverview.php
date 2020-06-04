<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Directdebits
 *
 * @package PayNL\Sdk\Model
 */
class DirectdebitOverview implements
    ModelInterface,
    Member\LinksAwareInterface
{
    use Member\LinksAwareTrait;

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
        if (null === $this->mandate) {
            $this->setMandate(new Mandate());
        }
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
        if (null === $this->directdebits) {
            $this->setDirectdebits(new Directdebits());
        }
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
