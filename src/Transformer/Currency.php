<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Exception\{InvalidArgumentException, UnexpectedValueException};
use PayNL\Sdk\Model\Currency as CurrencyModel;
use Zend\Hydrator\ClassMethods;

/**
 * Class Currency
 *
 * @package PayNL\Sdk\Transformer
 */
class Currency implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
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

        // always expect a JSON-encoded string
        $inputToTransform = json_decode($inputToTransform, true);
        if (null === $inputToTransform) {
            throw new UnexpectedValueException('Cannot transform');
        }

        $hydrator = new ClassMethods();
        if (false === array_key_exists('currencies', $inputToTransform)) {
            // get request
            return $hydrator->hydrate($inputToTransform, new CurrencyModel());
        }

        // get all request
        $currenciesArray = &$inputToTransform['currencies'];
        foreach ($currenciesArray as $key => $currencyArray) {
            $currency = $hydrator->hydrate($currencyArray, new CurrencyModel());
            $currenciesArray[$key] = $currency;
        }

        return $inputToTransform;
    }
}
