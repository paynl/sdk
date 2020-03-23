<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Exception\InvalidArgumentException;
use ReflectionClass, ReflectionException;

/**
 * Class Status
 *
 * @package PayNL\Sdk\Model
 */
class TransactionStatus extends Status
{
    /*
     * Status code constant definitions
     */
    public const STATUS_CANCELLED          = -90;
    public const STATUS_PARTIALLY_REFUNDED = -82;
    public const STATUS_REFUNDED_CUSTOMER  = -81;
    public const STATUS_EXPIRED            = -80;
    public const STATUS_REFUNDING          = -72;
    public const STATUS_CHARGEBACK         = -71;
    public const STATUS_MANUALLY_DECLINED  = -64;
    public const STATUS_DENIED             = -63;
    public const STATUS_FAILURE            = -60;
    public const STATUS_INVALID_AMOUNT     = -51;
    public const STATUS_UNKNOWN            = 0;
    public const STATUS_INITIALIZED        = 20;
    public const STATUS_PROCESSING         = 25;
    public const STATUS_PENDING1           = 50;
    public const STATUS_SUBSCRIPTION_OPEN  = 60;
    public const STATUS_PENDING2           = 70;
    public const STATUS_PROCESSED          = 75;
    public const STATUS_CONFIRMED          = 76;
    public const STATUS_PARTIALLY_PAID     = 80;
    public const STATUS_VERIFY             = 85;
    public const STATUS_PENDING3           = 90;
    public const STATUS_AUTHORIZED         = 95;
    public const STATUS_PARTIALLY_ACCEPTED = 97;
    public const STATUS_PAID               = 100;

    /**
     * TransactionStatus constructor.
     */
    public function __construct()
    {
        $this->setCode(static::STATUS_UNKNOWN);
    }

    /**
     * @return array
     */
    public function getAllowedStatus(): array
    {
        try {
            $ref = new ReflectionClass(static::class);
            return array_filter($ref->getConstants(), static function (string $key) {
                return 0 === strpos($key, 'STATUS_');
            }, ARRAY_FILTER_USE_KEY);
        } catch (ReflectionException $reflectionException) {
            // does not occur
            return [];
        }
    }

    /**
     * @param mixed $code
     *
     * @throws InvalidArgumentException
     *
     * @return TransactionStatus
     */
    public function setCode($code)
    {
        if (true === is_string($code)) {
            $code = (int)$code;
        } elseif (false === is_int($code)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given code must be an integer or a string containing a number, %s given',
                    is_object($code) ? get_class($code) : gettype($code)
                )
            );
        }

        $allowedStatus = $this->getAllowedStatus();

        if (false === in_array($code, $allowedStatus, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Code "%s" is not allowed',
                    $code
                )
            );
        }

        parent::setCode((string)$code);

        return $this;
    }

    /**
     * @return string|integer
     */
    public function getCode()
    {
        $code = parent::getCode();
        return (int)$code;
    }

    /**
     * @param mixed $constantNameOrCode
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function isStatus($constantNameOrCode): bool
    {
        if (true === is_string($constantNameOrCode)) {
            $constantNameOrCode = constant(static::class . '::' . $constantNameOrCode);
        } elseif (false === is_int($constantNameOrCode)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Argument given to %s must be a string or an integer, %s given',
                    __METHOD__,
                    is_object($constantNameOrCode) === true ? get_class($constantNameOrCode) : gettype($constantNameOrCode)
                )
            );
        }

        return $this->getCode() === $constantNameOrCode;
    }
}
