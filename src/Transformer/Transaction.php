<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Exception\{InvalidArgumentException, UnexpectedValueException};
use PayNL\Sdk\Model\Transaction as TransactionModel;
use PayNL\Sdk\Hydrator\Transaction as TransactionHydrator;

/**
 * Class Transaction
 *
 * @package PayNL\Sdk\Transformer
 */
class Transaction implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        if (false === is_string($inputToTransform)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expects argument given to be a string, %s given',
                    __METHOD__,
                    is_object($inputToTransform) ? get_class($inputToTransform) : gettype($inputToTransform)
                )
            );
        }

        // always expect a JSON-encoded string
        $inputToTransform = json_decode($inputToTransform, true);
        if (null === $inputToTransform) {
            throw new UnexpectedValueException('Cannot transform');
        }

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
