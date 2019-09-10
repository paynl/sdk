<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Model\Merchant as MerchantModel;
use PayNL\Sdk\Hydrator\Merchant as MerchantHydrator;

/**
 * Class Merchant
 *
 * @package PayNL\Sdk\Transformer
 */
class Merchant extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new MerchantHydrator();
        if (false === array_key_exists('merchants', $inputToTransform)) {
            // get request
            return $hydrator->hydrate($inputToTransform, new MerchantModel());
        }

        // get all request
        $merchants = &$inputToTransform['merchants'];
        foreach ($merchants as $key => $merchantArray) {
            $merchant = $hydrator->hydrate($merchantArray, new MerchantModel());
            $merchants[$key] = $merchant;
        }

        return $inputToTransform;
    }
}
