<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use \Exception;
use PayNL\Sdk\Model\Transaction as TransactionModel;
use PayNL\Sdk\Hydrator\Transaction as TransactionHydrator;

/**
 * Class Transaction
 *
 * @package PayNL\Sdk\Transformer
 */
class Transaction extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new TransactionHydrator();
        if (false === array_key_exists('transactions', $inputToTransform)) {
            // get request
            return $hydrator->hydrate($inputToTransform, new TransactionModel());
        }

        // get all request
        $transactions = &$inputToTransform['transactions'];
        foreach ($transactions as $key => $transactionArray) {
            $transaction = $hydrator->hydrate($transactionArray, new TransactionModel());
            $transactions[$key] = $transaction;
        }

        return $inputToTransform;
    }

}
