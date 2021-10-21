<?php

namespace Paynl\Result\Payment;

use Paynl\Result\Result;

class AuthenticationStatus extends Result
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $arrResult = $this->data;

        $result = array(
            'result' => !empty($arrResult['request']['result']) ? (string)$arrResult['request']['result'] : "0"
        );

        if ($result['result'] > 0) {
            $result['transactionID'] = $arrResult['threeDs']['transactionID'];
            $result['transactionStatusCode'] = $arrResult['threeDs']['transactionStatusCode'];
        }

        return $result;
    }
}