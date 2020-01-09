<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;


class Response extends AbstractTransformer
{
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return $this->hydrator->hydrate($inputToTransform, $this->getModel());
    }
}
