<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Hydrator\Simple as SimpleHydrator,
    Model\Currency as CurrencyModel
};

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
     * @return CurrencyModel
     */
    public function transform($inputToTransform): CurrencyModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        // get request
        /** @var CurrencyModel $currencyModel */
        $currencyModel = (new SimpleHydrator())->hydrate($inputToTransform, new CurrencyModel());
        return $currencyModel;
    }
}
