<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Hydrator\Qr as QrHydrator;
use PayNL\Sdk\Model\Qr as QrModel;

/**
 * Class Qr
 *
 * @package PayNL\Sdk\Transformer
 */
class _Qr extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @return QrModel
     */
    public function transform($inputToTransform): QrModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);
        return (new QrHydrator())->hydrate($inputToTransform, new QrModel());
    }
}
