<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\UnexpectedValueException;
use PayNL\Sdk\Validator\InputType as InputTypeValidator;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Class AbstractTransformer
 *
 * @package PayNL\Sdk\Transformer
 */
abstract class AbstractTransformer implements TransformerInterface
{
    /**
     * @param string $inputToTransform
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     *
     * @return mixed
     */
    protected function getDecodedInput(string $inputToTransform)
    {
        $validator = new InputTypeValidator();
        if (false === $validator->isValid($inputToTransform, 'string')) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $validator->getMessages())
            );
        }

        // always expect a JSON-encoded string
        $inputToTransform = (new JsonEncoder())->decode($inputToTransform, 'json');
        if (null === $inputToTransform) {
            throw new UnexpectedValueException('Cannot transform');
        }

        return $inputToTransform;
    }
}
