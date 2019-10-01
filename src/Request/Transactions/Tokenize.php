<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;

/**
 * Class Tokenize
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Tokenize extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * Tokenize constructor.
     *
     * @param string $transactionId
     * @param string $cardIdOrAuthToken
     */
    public function __construct(string $transactionId, string $cardIdOrAuthToken)
    {
        $body = [
            'companyCardId'    => 0 === strpos($cardIdOrAuthToken, 'VY-') ? $cardIdOrAuthToken : '',
            'companyCardToken' => 0 !== strpos($cardIdOrAuthToken, 'VY-') ? $cardIdOrAuthToken : '',
        ];

        unset($body[array_search('', $body, true)]);

        $this->setTransactionId($transactionId)
            ->setBody((object)$body);

    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "transactions/{$this->getTransactionId()}/tokenize";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }
}
