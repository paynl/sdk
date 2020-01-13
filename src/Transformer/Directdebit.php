<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Hydrator\{
    Mandate as MandateHydrator,
    Directdebit as DirectdebitHydrator,
    Links as LinksHydrator
};
use PayNL\Sdk\Model\{
    Mandate as MandateModel,
    Directdebit as DirectdebitModel,
    Links as LinksModel
};
use Exception;

/**
 * Class Directdebit
 *
 * @package PayNL\Sdk\Transformer
 */
class _Directdebit extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     *
     * @return array
     */
    public function transform($inputToTransform): array
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $output = [
            'mandate'      => null,
            'directdebits' => [],
            'links'        => null,
        ];

        if (true === array_key_exists('mandate', $inputToTransform)) {
            $output['mandate'] = (new MandateHydrator())->hydrate($inputToTransform['mandate'], new MandateModel());
        }

        if (true === array_key_exists('directdebits', $inputToTransform)) {
            foreach ($inputToTransform['directdebits'] as $directdebitArray) {
                $output['directdebits'][] = (new DirectdebitHydrator())->hydrate($directdebitArray, new DirectdebitModel());
            }
        }

        if (true === array_key_exists('_links', $inputToTransform)) {
            $output['links'] = (new LinksHydrator())->hydrate($inputToTransform['_links'], new LinksModel());
        }

        return $output;
    }
}
