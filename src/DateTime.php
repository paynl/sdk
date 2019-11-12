<?php

declare(strict_types=1);

namespace PayNL\Sdk;

use Exception, DateTime as stdDateTime, DateTimeZone, RuntimeException;
use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class DateTime
 *
 * @package PayNL\Sdk
 */
class DateTime extends stdDateTime implements \JsonSerializable
{
    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     *
     * @throws InvalidArgumentException
     * @throws Exception
     *
     * @return bool|DateTime
     *
     * @internal Dirty hack to "override" the parents static function because it always returns itself...
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        /** @var stdDateTime $dateTime */
        $dateTime = parent::createFromFormat($format, $time, $timezone);

        return (new self())->setTimestamp($dateTime->getTimestamp());
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return (string)$this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format(static::ATOM);
    }

    /**
     * @throws Exception
     *
     * @return DateTime
     */
    public static function now(): self
    {
        return new self();
    }
}
