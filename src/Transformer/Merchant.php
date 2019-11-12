<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Model\Merchant as MerchantModel,
    Hydrator\Merchant as MerchantHydrator
};
use Exception;

/**
 * Class Merchant
 *
 * @package PayNL\Sdk\Transformer
 */
class Merchant extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     *
     * @return MerchantModel
     */
    public function transform($inputToTransform): MerchantModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        // get request
        return (new MerchantHydrator())->hydrate($inputToTransform, new MerchantModel());
    }
}
