<?php

namespace Paynl\Api\Creditcard;

use Paynl\Api\Api;

/**
 * Encrypted transaction
 *
 * @author Michael Roterman <michael@pay.nl>
 */
class CseTdsStatus extends Api
{
    /**
     * @var int the version of the api
     */
    protected $version = 2;

    /**
     * @var string
     */
    private $transactionId;
    
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('creditcard/cseTdsStatus');
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return array_merge(parent::getData(), array(
            'transactionId' => $this->transactionId
        ));
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }
}
