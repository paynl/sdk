<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Hydrator\{
    Mandate as MandateHydrator,
    Directdebit as DirectdebitHydrator
};
use PayNL\Sdk\Model\{
    Mandate as MandateModel,
    Directdebit as DirectdebitModel
};

/**
 * Class Directdebit
 *
 * @package PayNL\Sdk\Transformer
 */
class Directdebit extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @return
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $output = [
            'mandate' => null,
            'directdebits' => [],
        ];

        if (true === array_key_exists('mandate', $inputToTransform)) {
            $output['mandate'] = (new MandateHydrator())->hydrate($inputToTransform['mandate'], new MandateModel());
        }

        if (true === array_key_exists('directdebits', $inputToTransform)) {
            foreach ($inputToTransform['directdebits'] as $directdebitArray) {
                $output['directdebits'][] = (new DirectdebitHydrator())->hydrate($directdebitArray, new DirectdebitModel());
            }
        }

        return $output;
    }

}
