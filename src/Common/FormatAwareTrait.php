<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use PayNL\Sdk\Exception\{
    InvalidArgumentException,
    LogicException
};

/**
 * Trait FormatAwareTrait
 *
 * @package PayNL\Sdk\Common
 */
trait FormatAwareTrait
{
    /**
     * @var string
     */
    protected $format = FormatAwareInterface::FORMAT_OBJECTS;

    /**
     * @throws LogicException
     *
     * @return void
     */
    protected function checkInterfaceImplementation(): void
    {
        if (false === in_array(FormatAwareInterface::class, class_implements(static::class, false), true)) {
            throw new LogicException(
                sprintf(
                    'Class "%s" does not implement interface "%s"',
                    static::class,
                    FormatAwareInterface::class
                )
            );
        }
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        $this->checkInterfaceImplementation();

        return $this->format;
    }

    /**
     * @param string $format
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setFormat(string $format): self
    {
        $this->checkInterfaceImplementation();

        if (false === in_array($format, static::ALLOWED_FORMATS, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Format "%s" is not allowed, choose one of the following: %s',
                    $format,
                    implode(', ', static::ALLOWED_FORMATS)
                )
            );
        }

        $this->format = $format;
        return $this;
    }

    /**
     * @param string $format
     *
     * @return bool
     */
    public function isFormat(string $format): bool
    {
        return $this->getFormat() === $format;
    }
}
