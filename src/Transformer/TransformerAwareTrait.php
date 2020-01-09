<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;


trait TransformerAwareTrait
{
    /**
     * @var TransformerInterface
     */
    protected $transformer;

    public function getTransformer(): TransformerInterface
    {
        return $this->transformer;
    }

    public function setTransformer(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;
        return $this;
    }
}
