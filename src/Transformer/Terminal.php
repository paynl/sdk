<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Hydrator\Terminal as TerminalHydrator;
use PayNL\Sdk\Model\Terminal as TerminalModel;

/**
 * Class Terminal
 *
 * @package PayNL\Sdk\Transformer
 */
class Terminal extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new TerminalHydrator();

        $transactions = &$inputToTransform['pin'];
        foreach ($transactions as $key => $terminalArray) {
            $terminal = $hydrator->hydrate($terminalArray, new TerminalModel());
            $transactions[$key] = $terminal;
        }

        return $inputToTransform;
    }
}
