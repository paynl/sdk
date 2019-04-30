<?php

namespace Paynl\Result\Instore;

use Paynl\Result\Result;

/**
 * Result class for getTerminals
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Receipt extends Result
{
    public function getReceipt()
    {
        return base64_decode($this->data['receipt']);
    }

    public function getApprovalId()
    {
        return $this->data['approvalId'];
    }

    public function getCardBrandId()
    {
        return $this->data['cardBrandId'];
    }

    public function getCardBrandName()
    {
        return $this->data['cardBrandName'];
    }

    public function getPaymentProfileId()
    {
        return $this->data['paymentProfileId'];
    }

    public function getPaymentProfileName()
    {
        return $this->data['paymentProfileName'];
    }
}
