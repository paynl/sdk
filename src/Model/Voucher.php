<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;

/**
 * Class Voucher
 *
 * @package PayNL\Sdk\Model
 */
class Voucher implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
//    protected $cardNumber;

    /**
     * @var Amount
     */
    protected $amount;

    /**
     * @var string
     */
    protected $pinCode;

    /**
     * @var string
     */
    protected $posId;

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     *
     * @return Voucher
     */
    public function setAmount(Amount $amount): Voucher
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getPinCode(): string
    {
        return $this->pinCode;
    }

    /**
     * @param string $pinCode
     *
     * @return Voucher
     */
    public function setPinCode(string $pinCode): Voucher
    {
        $this->pinCode = $pinCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosId(): string
    {
        return $this->posId;
    }

    /**
     * @param string $posId
     *
     * @return Voucher
     */
    public function setPosId(string $posId): Voucher
    {
        $this->posId = $posId;
        return $this;
    }
}
