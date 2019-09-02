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

        $transactions = &$inputToTransform['terminals'];
        foreach ($transactions as $key => $transactionArray) {
            $transaction = $hydrator->hydrate($transactionArray, new TerminalModel());
            $transactions[$key] = $transaction;
        }

        return $inputToTransform;
    }
}
