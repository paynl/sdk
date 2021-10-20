<?php

namespace Paynl\Result\Payment;

use Paynl\Result\Result;

class Authorize extends Result
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $arrResult = $this->data;

        $result = array(
            'result' => 0,
        );

        if (!empty($arrResult['request']['result']) && $arrResult['request']['result'] == 1) {
            if (!empty($arrResult['payment']['bankCode']) && $arrResult['payment']['bankCode'] == "00") {
                if (!empty($arrResult['transaction']['state']) && in_array(
                        $arrResult['transaction']['state'],
                        array(85, 95, 100)
                    )) {
                    $result['result'] = 1;
                }
            }
        }

        if ($result['result'] > 0) {
            $result['nextAction'] = !empty($arrResult['transaction']['stateName']) ? strtolower(
                $arrResult['transaction']['stateName']
            ) : '';
            $result['orderId'] = !empty($arrResult['transaction']['orderId']) ? $arrResult['transaction']['orderId'] : "";
            $result['entranceCode'] = !empty($arrResult['transaction']['entranceCode']) ? $arrResult['transaction']['entranceCode'] : "";
        } else {
            if (isset($arrResult['request'])) {
                $result['errorId'] = ! empty($arrResult['request']['errorId'])
                    ? $arrResult['request']['errorId']
                    : '';
                $result['errorMessage'] = ! empty($arrResult['request']['errorMessage'])
                    ? $arrResult['request']['errorMessage']
                    : '';
            } else {
                $result['errorMessage'] = isset($arrResult['message']) && ! empty($arrResult['message'])
                    ? $arrResult['message']
                    : '';
            }
        }

        return $result;
    }
}
