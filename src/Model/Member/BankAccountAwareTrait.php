<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\BankAccount;

/**
 * Trait BankAccountAwareTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait BankAccountAwareTrait
{
    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * @return BankAccount
     */
    public function getBankAccount(): BankAccount
    {
        if (null === $this->bankAccount) {
            $this->setBankAccount(new BankAccount());
        }
        return $this->bankAccount;
    }

    /**
     * @param BankAccount $bankAccount
     *
     * @return static
     */
    public function setBankAccount(BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }
}
