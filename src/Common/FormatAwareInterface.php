<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

/**
 * Interface FormatAwareInterface
 *
 * @package PayNL\Sdk\Common
 */
interface FormatAwareInterface
{
    /*
     * Format constants declaration
     */
    public const FORMAT_JSON    = 'json';
    public const FORMAT_XML     = 'xml';
    public const FORMAT_OBJECTS = 'objects';

    public const ALLOWED_FORMATS = [
        self::FORMAT_JSON,
        self::FORMAT_XML,
        self::FORMAT_OBJECTS,
    ];

    /**
     * @return string
     */
    public function getFormat(): string;

    /**
     * @param string $format
     *
     * @return static
     */
    public function setFormat(string $format);

    /**
     * @param string $format
     *
     * @return bool
     */
    public function isFormat(string $format): bool;
}
