<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use stdClass;

/**
 * Class Simple
 *
 * @package PayNL\Sdk\Transformer
 */
class _Simple extends AbstractTransformer
{
    public function transform($inputToTransform): stdClass
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $returnInstance = new stdClass();

        foreach ($inputToTransform as $key => $value) {
            if (0 === strpos($key, '_')) {
                continue;
            }
            $returnInstance->$key = $value;
        }

        return $returnInstance;
    }
}
