<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Exception\UnexpectedValueException;
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
     * @param string $jsonEncodedString
     *
     * @throws UnexpectedValueException
     *
     * @return mixed
     */
    protected function getDecodedInput(string $jsonEncodedString)
    {
        // always expect a JSON-encoded string
        try {
            $transformedInput = (new JsonEncoder())->decode($jsonEncodedString, 'json');
        } catch (NotEncodableValueException $notEncodableValueException) {
            throw new UnexpectedValueException('Unable to decode the response', 500, $notEncodableValueException);
        }

        return $this->filterNotNull($transformedInput);
    }

    /**
     * @param array $input
     *
     * @return array
     */
    protected function filterNotNull(array $input): array
    {
        $context = $this;

        return array_filter(
            array_map(static function ($item) use ($context) {
                return is_array($item) === true ? $context->filterNotNull($item) : $item;
            }, $input),
            static function ($item) {
                return $item !== '' && $item !== null && (is_array($item) === false || 0 < count($item));
            }
        );
    }
}
