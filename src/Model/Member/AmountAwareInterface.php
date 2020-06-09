<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Amount;

/**
 * Interface AmountAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface AmountAwareInterface
{
    /**
     * @return Amount
     */
    public function getAmount(): Amount;

    /**
     * @param Amount $amount
     *
     * @return static
     */
    public function setAmount(Amount $amount);
}
