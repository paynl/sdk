<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use stdClass;

/**
 * Class Simple
 *
 * @package PayNL\Sdk\Transformer
 */
class Simple extends AbstractTransformer
{
    public function transform($inputToTransform): stdClass
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $returnInstance = new stdClass();

        foreach ($inputToTransform as $key => $value) {
            $returnInstance->$key = $value;
        }

        return $returnInstance;
    }
}
