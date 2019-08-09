<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Model\Currency as CurrencyModel;
use Zend\Hydrator\ClassMethods;

/**
 * Class Currency
 *
 * @package PayNL\Sdk\Transformer
 */
class Currency extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

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
