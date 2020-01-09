<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;


interface TransformerAwareInterface
{
    public function getTransformer(): TransformerInterface;

    public function setTransformer(TransformerInterface $transformer);
}
