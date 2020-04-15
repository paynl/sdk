<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

/**
 * Interface TransformerAwareInterface
 *
 * @package PayNL\Sdk\Transformer
 */
interface TransformerAwareInterface
{
    /**
     * @return TransformerInterface|null
     */
    public function getTransformer(): ?TransformerInterface;

    /**
     * @param TransformerInterface $transformer
     *
     * @return static
     */
    public function setTransformer(TransformerInterface $transformer);
}
