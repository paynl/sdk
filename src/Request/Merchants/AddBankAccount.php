<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Merchants;

use PayNL\Sdk\Model\BankAccount;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\MerchantIdTrait;

/**
 * Class AddBankAccount
 *
 * @package PayNL\Sdk\Request\Merchants
 */
class AddBankAccount extends AbstractRequest
{
    use MerchantIdTrait;

    /**
     * AddBankAccount constructor.
     *
     * @param string $merchantId
     * @param BankAccount $bankAccount
     */
    public function __construct(string $merchantId, BankAccount $bankAccount)
    {
        $this->setMerchantId($merchantId);
        $this->setBody($bankAccount);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "merchants/{$this->getMerchantId()}/bankaccounts";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }


}
