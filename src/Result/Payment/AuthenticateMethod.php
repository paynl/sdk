<?php

namespace Paynl\Result\Payment;

class AuthenticateMethod extends Authorize
{
    public function getData()
    {
        $arrResult = $this->data;

        $result = array(
            'result' => !empty($arrResult['request']['result']) ? (int)$arrResult['request']['result'] : 0,
        );

        if (!empty($arrResult['request']['result']) && $arrResult['request']['result'] == 1) {
            if (!empty($arrResult['payment']['bankCode']) && $arrResult['payment']['bankCode'] == "00") {
                if (!empty($arrResult['transaction']['state']) && in_array(
                        $arrResult['transaction']['state'],
                        array(85, 95, 100)
                    )) {
                    $result['result'] = 1;
                    $result['nextAction'] = !empty($arrResult['transaction']['stateName']) ? strtolower($arrResult['transaction']['stateName']) : '';
                    $result['orderId'] = !empty($arrResult['transaction']['orderId']) ? $arrResult['transaction']['orderId'] : "";
                    $result['entranceCode'] = !empty($arrResult['transaction']['entranceCode']) ? $arrResult['transaction']['entranceCode'] : "";
                }
            }
        }

        if ($result['result'] > 0) {
            if (isset($arrResult['transaction']) && is_array($arrResult['transaction'])) {
                $result['orderId'] = $arrResult['transaction']['orderId'];
                $result['transaction']['transactionId'] = $arrResult['transaction']['orderId'];
                $result['transaction']['entranceCode'] = $arrResult['transaction']['entranceCode'];
            }
            if (isset($arrResult['threeDs']) && is_array($arrResult['threeDs'])) {
                $result = array_merge($result, $arrResult['threeDs']);
                $result['transactionID'] = $arrResult['threeDs']['transactionID'];
                $result['acquirerID'] = $arrResult['threeDs']['acquirerID'];
            }
        } else {
            $result['errorId'] = !empty($arrResult['request']['errorId']) ? $arrResult['request']['errorId'] : "";
            $result['errorMessage'] = !empty($arrResult['request']['errorMessage']) ? $arrResult['request']['errorMessage'] : "";
        }

        return $result;
    }
}
