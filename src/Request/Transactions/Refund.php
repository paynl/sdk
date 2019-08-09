<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;
use PayNL\Sdk\Model\Refund as RefundModel;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

/**
 * Class Refund
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Refund extends AbstractRequest
{
    use TransactionIdTrait;

    public function __construct(string $transactionId, RefundModel $refund)
    {
        $encoder = new JsonEncoder();
        $contentTypeHeader = 'application/json';
        if (static::FORMAT_XML === $this->getFormat()) {
            $encoder = new XmlEncoder();
            $encoder->setRootNodeName('request');
            $contentTypeHeader = 'application/xml';
        }

        $this->setTransactionId($transactionId)
            ->addHeader('Content-Type', $contentTypeHeader)
            ->setBody($encoder->encode($refund, $this->getFormat()))
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "transactions/{$this->getTransactionId()}/refund";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }


}
