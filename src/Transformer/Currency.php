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
     *
     * @return array|CurrencyModel
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new ClassMethods();
        if (false === array_key_exists('currencies', $inputToTransform)) {
            // get request
            /** @var CurrencyModel $currencyModel */
            $currencyModel = $hydrator->hydrate($inputToTransform, new CurrencyModel());
            return $currencyModel;
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
