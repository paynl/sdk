<?php

namespace Paynl\Api\Payment;

/**
 * @author Michael Roterman <michael@pay.nl>
 */
class PaymentAuthenticate extends PaymentAuthorize
{
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest("Payment/authenticate", 1);
    }
}
