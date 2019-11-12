<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Qr;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Model\Qr as QrModel,
    Transformer\TransformerInterface,
    Transformer\Simple as SimpleTransformer
};

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

    /**
     * @return SimpleTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new SimpleTransformer();
    }
}
