<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Qr;

use PayNL\Sdk\Model\Qr;
use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Decode
 *
 * @package PayNL\Sdk\Request\Qr
 */
class Decode extends AbstractRequest
{
    public function __construct(string $uuid, string $secret, string $padChar = '0', string $referenceType = Qr::REFERENCE_TYPE_STRING)
    {
        $this->setBody(
            (new Qr())->setUuid($uuid)
                ->setSecret($secret)
                ->setPadChar($padChar)
                ->setReferenceType($referenceType)
        );
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'qr/decode';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }
}
