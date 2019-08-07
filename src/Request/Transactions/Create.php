<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Model\Transaction;
use PayNL\Sdk\Request\AbstractRequest;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

/**
 * Class Create
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Create extends AbstractRequest
{
    /**
     * Create constructor.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $encoder = new JsonEncoder();
        if (static::FORMAT_XML === $this->getFormat()) {
            $encoder = new XmlEncoder();
            $encoder->setRootNodeName('request');
        }

        $this->setBody($encoder->encode($transaction, $this->getFormat()));
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'transactions';
    }
}
