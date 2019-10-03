<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Qr;

use PayNL\Sdk\Model\Qr as QrModel;
use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Encode
 *
 * @package PayNL\Sdk\Request\Qr
 */
class Encode extends AbstractRequest
{
    public function __construct(QrModel $qr)
    {
        $this->setBody($qr);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'qr/encode';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }
}
