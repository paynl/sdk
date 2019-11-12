<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Hydrator\Terminals as TerminalsHydrator;
use PayNL\Sdk\Model\Terminals as TerminalsModel;

/**
 * Class Terminal
 *
 * @package PayNL\Sdk\Transformer
 */
class Terminals extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @return TerminalsModel
     */
    public function transform($inputToTransform): TerminalsModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return (new TerminalsHydrator())->hydrate($inputToTransform, new TerminalsModel());
    }
}
