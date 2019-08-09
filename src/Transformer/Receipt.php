<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\UnexpectedValueException;
use PayNL\Sdk\Model\Receipt as ReceiptModel;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use PayNL\Sdk\Hydrator\Receipt as ReceiptHydrator;

/**
 * Class TransactionReceipt
 *
 * @package PayNL\Sdk\Transformer
 */
class Receipt implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform): ReceiptModel
    {
        if (false === is_string($inputToTransform)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expects argument given to be a string, %s given',
                    __METHOD__,
                    is_object($inputToTransform) ? get_class($inputToTransform) : gettype($inputToTransform)
                )
            );
        }

        $inputToTransform = (new JsonEncoder())->decode(
            $inputToTransform,
            'json'
        );
        if (null === $inputToTransform) {
            throw new UnexpectedValueException('Cannot transform');
        }

        return (new ReceiptHydrator())->hydrate($inputToTransform, new ReceiptModel());
    }
}
