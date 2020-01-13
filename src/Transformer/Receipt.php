<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Model\Receipt as ReceiptModel;
use PayNL\Sdk\Hydrator\Receipt as ReceiptHydrator;

/**
 * Class TransactionReceipt
 *
 * @package PayNL\Sdk\Transformer
 */
class _Receipt extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform): ReceiptModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return (new ReceiptHydrator())->hydrate($inputToTransform, new ReceiptModel());
    }
}
