<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Qr;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\NoContent as NoContentTransformer
};

/**
 * Class Validate
 *
 * @package PayNL\Sdk\Request\Qr
 */
class Validate extends AbstractRequest
{
    /**
     * Validate constructor.
     *
     * @param string $uuid
     * @param string $secret
     */
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
        return 'qr/validate';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }

    /**
     * @return NoContentTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new NoContentTransformer();
    }
}
