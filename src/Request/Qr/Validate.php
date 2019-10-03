<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Qr;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Validate
 *
 * @package PayNL\Sdk\Request\Qr
 */
class Validate extends AbstractRequest
{
    public function __construct(string $uuid, string $secret)
    {
        $this->setBody((object)[
            'uuid' => $uuid,
            'secret' => $secret,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'qr/0/validate';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }
}
