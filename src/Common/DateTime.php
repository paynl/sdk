<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Exception,
    DateTime as stdDateTime,
    DateTimeZone,
    JsonSerializable
;

/**
 * Class DateTime
 *
 * Extends the PHP DateTime object to make it json serializable
 *
 * @package PayNL\Sdk
 */
class DateTime extends stdDateTime implements JsonSerializable
{
    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     *
     * @return DateTime
     *
     * @internal Dirty hack to "override" the parents static function because it always returns itself...
     */
    public static function createFromFormat($format, $time, $timezone = null): self
    {
        /** @var stdDateTime $dateTime */
        $dateTime = parent::createFromFormat($format, $time, $timezone);

        try {
            return (new self())->setTimestamp($dateTime->getTimestamp());
        } catch (Exception $e) {
            // does nothing, theoretically this does not occur
        }
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
     * @return DateTime
     */
    public static function now(): self
    {
        try {
            return new self();
        } catch (Exception $e) {
            // does nothing, theoretically this does not occur
        }
    }
}
