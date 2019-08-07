<?php
declare(strict_types=1);

namespace PayNL\Sdk;

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
     * @param null $timezone
     *
     * @throws \Exception
     *
     * @return bool|DateTime
     *
     * @internal Dirty hack to "override" the parents static function because it always returns itself...
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        return (new self())->setTimestamp(parent::createFromFormat($format, $time, $timezone)->getTimestamp());
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
