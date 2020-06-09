<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Voucher
 *
 * @package PayNL\Sdk\Model
 */
class Voucher implements
    ModelInterface,
    Member\LinksAwareInterface,
    Member\AmountAwareInterface,
    JsonSerializable
{
    use Member\LinksAwareTrait;
    use Member\AmountAwareTrait;
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $pinCode;

    /**
     * @var string
     */
    protected $posId;

    /**
     * @var int
     */
    protected $balance;

    /**
     * @return string
     */
    public function getPinCode(): string
    {
        return (string)$this->pinCode;
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
        return (string)$this->posId;
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

    /**
     * @return int|null
     */
    public function getBalance(): ?int
    {
        return $this->balance;
    }

    /**
     * @param int $balance
     *
     * @return Voucher
     */
    public function setBalance(int $balance): Voucher
    {
        $this->balance = $balance;
        return $this;
    }
}
