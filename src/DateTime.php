<?php
declare(strict_types=1);

namespace PayNL\Sdk;

use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class DateTime
 *
 * @package PayNL\Sdk
 */
class DateTime extends \DateTime implements \JsonSerializable
{
    /**
     * @param string $format
     * @param string $time
     * @param \DateTimeZone|null $timezone
     *
     * @throws \Exception
     * @throws InvalidArgumentException
     *
     * @return bool|DateTime
     *
     * @internal Dirty hack to "override" the parents static function because it always returns itself...
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        /** @var \DateTime $dateTime */
        $dateTime = parent::createFromFormat($format, $time, $timezone);
        if (false === $dateTime) {
            throw new InvalidArgumentException(
                'Invalid time given'
            );
        }

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
}
