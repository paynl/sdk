<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\UnexpectedValueException;
use PayNL\Sdk\Validator\InputType as InputTypeValidator;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

/**
 * Class AbstractTransformer
 *
 * @package PayNL\Sdk\Transformer
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractTransformer implements TransformerInterface
{
    /**
     * @param string $inputToTransform
     *
     * @throws UnexpectedValueException
     *
     * @return mixed
     */
    protected function getDecodedInput(string $inputToTransform)
    {
        // always expect a JSON-encoded string
        try {
            $inputToTransform = (new JsonEncoder())->decode($inputToTransform, 'json');
        } catch (NotEncodableValueException $notEncodableValueException) {
            throw new UnexpectedValueException('Cannot transform', 500);
        }

        return $inputToTransform;
    }
}
