<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Amount;

/**
 * Trait AmountAwareTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait AmountAwareTrait
{
    /**
     * @var Amount
     */
    protected $amount;

    public function getAmount(): Amount
    {
        if (null === $this->amount) {
            $this->setAmount(new Amount());
        }
        return $this->amount;
    }

    /**
     * @param Amount $amount
     *
     * @return static
     */
    public function setAmount(Amount $amount): self
    {
        $this->amount = $amount;
        return $this;
    }
}
