<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

/**
 * Class NoContent
 *
 * @package PayNL\Sdk\Transformer
 */
class NoContent implements TransformerInterface
{
    public function transform($inputToTransform)
    {
        return [];
    }
}
