<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Statistics;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\UnexpectedValueException;
use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Statistics
 */
class Get extends AbstractRequest
{
    public const TYPE_MANAGEMENT = 'management';
    public const TYPE_SESSIONS   = 'sessions';

    /**
     * @var string
     */
    protected $type = '';

    public function __construct(string $type)
    {
        $this->setType($type);
    }

    /**
     * @throws UnexpectedValueException when type is prohibited
     *
     * @return string
     */
    public function getType(): string
    {
        $type = $this->type;
        if ('' === $type) {
            throw new UnexpectedValueException(
                sprintf(
                    'No type is set, choose one of "%s"',
                    implode(', ', [ self::TYPE_MANAGEMENT, self::TYPE_SESSIONS ])
                ),
                409
            );
        }
        return $type;
    }

    /**
     * @param string $type
     *
     * @throws InvalidArgumentException when given type is not allowed
     *
     * @return Get
     */
    public function setType(string $type): self
    {
        $types = [
            self::TYPE_MANAGEMENT,
            self::TYPE_SESSIONS
        ];

        if (false === in_array($type, $types, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s is not allowed as type, choose one of "%s"',
                    $type,
                    implode(', ', $types)
                ),
                409
            );
        }

        $this->type = $type;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "statistics/{$this->getType()}";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }
}
