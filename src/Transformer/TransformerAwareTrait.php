<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

/**
 * Trait TransformerAwareTrait
 *
 * @package PayNL\Sdk\Transformer
 */
trait TransformerAwareTrait
{
    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * @inheritDoc
     */
    public function getTransformer(): ?TransformerInterface
    {
        return $this->transformer;
    }

    /**
     * @inheritDoc
     */
    public function setTransformer(TransformerInterface $transformer): self
    {
        $this->transformer = $transformer;
        return $this;
    }
}
