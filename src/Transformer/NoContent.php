<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

/**
 * Class NoContent
 *
 * @package PayNL\Sdk\Transformer
 */
class _NoContent implements TransformerInterface
{
    public function transform($inputToTransform)
    {
        return [];
    }
}
