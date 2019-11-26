<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Model\Currencies as CurrenciesModel,
    Hydrator\Currencies as CurrenciesHydrator
};

/**
 * Class Currencies
 *
 * @package PayNL\Sdk\Transformer
 */
class Currencies extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @return CurrenciesModel
     */
    public function transform($inputToTransform): CurrenciesModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return (new CurrenciesHydrator())->hydrate($inputToTransform, new CurrenciesModel());
    }
}
