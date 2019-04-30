<?php

namespace Paynl\Api\Refund;

use Paynl\Error;

/**
 * Description of Info
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Info extends Refund
{
    protected $apiTokenRequired = true;

    /**
     * @var string
     */
    private $refundId;
    /**
     * Set the refundId
     *
     * @param string $refundId
     */
    public function setRefundId($refundId)
    {
        $this->refundId = $refundId;
    }

    /**
     * @inheritdoc
     * @throws Error\Required RefundId is required
     */
    protected function getData()
    {
        if (empty($this->refundId)) {
            throw new Error\Required('RefundId required');
        }

        $this->data['refundId'] = $this->refundId;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('refund/info');
    }
}
