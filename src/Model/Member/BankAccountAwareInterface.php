<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\BankAccount;

/**
 * Interface BankAccountAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface BankAccountAwareInterface
{
    /**
     * @return BankAccount
     */
    public function getBankAccount(): BankAccount;

    /**
     * @param BankAccount $bankAccount
     *
     * @return static
     */
    public function setBankAccount(BankAccount $bankAccount);
}
