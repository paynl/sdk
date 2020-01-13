<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Model\Refund as RefundModel;
use PayNL\Sdk\Hydrator\Refund as RefundHydrator;

/**
 * Class Refund
 *
 * @package PayNL\Sdk\Transformer
 */
class _Refund extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new RefundHydrator();
        return $hydrator->hydrate($inputToTransform, new RefundModel());
    }
}
