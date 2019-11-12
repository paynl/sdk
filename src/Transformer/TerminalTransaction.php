<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Hydrator\TerminalTransaction as TerminalTransactionHydrator;
use PayNL\Sdk\Model\TerminalTransaction as TerminalTransactionModel;

/**
 * Class TerminalTransaction
 *
 * @package PayNL\Sdk\Transformer
 */
class TerminalTransaction extends AbstractTransformer
{
    public function transform($inputToTransform): TerminalTransactionModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        /** @var TerminalTransactionModel $terminalTransaction */
        $terminalTransaction = (new TerminalTransactionHydrator())
            ->hydrate($inputToTransform, new TerminalTransactionModel())
        ;
        return $terminalTransaction;
    }
}
