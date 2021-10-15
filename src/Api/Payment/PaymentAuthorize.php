<?php

namespace Paynl\Api\Payment;

use Paynl\Api\Api;
use Paynl\Helper;

/**
 * @author Michael Roterman <michael@pay.nl>
 */
class PaymentAuthorize extends AbstractPaymentRequest
{
    private $_amount;
    private $_finishUrl = '';
    private $_ipaddress = '';
    private $_currency = '';
    private $_description = '';
    private $_cardData = '';
    private $_identifier = '';

    protected $apiTokenRequired = true;
    protected $serviceIdRequired = true;

    public function setAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new Error('Amount is niet numeriek', 1);
        }
        $this->_amount = (int)$amount;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function getFinishUrl()
    {
        return $this->_finishUrl;
    }

    public function setFinishUrl($finishUrl)
    {
        $this->_finishUrl = $finishUrl;
    }

    public function getIpAddress()
    {
        return !empty($this->_ipaddress) ? $this->_ipaddress : Helper::getIp();
    }

    public function setIpAddress($ipAddress)
    {
        $this->_ipaddress = $ipAddress;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function setKeyIdentifier($identifier)
    {
        $this->_identifier = $identifier;
    }

    public function getKeyIdentifier()
    {
        return $this->_identifier;
    }

    public function setCardData($carddata)
    {
        $this->_cardData = $carddata;
    }

    public function getCardData()
    {
        return $this->_cardData;
    }

    public function getData()
    {
        $arrData = array(
            'transaction' => parent::getData(),
            'payment' => array(
                'method' => 'cse'
            )
        );

        if (!empty($this->getThreeDSTransactionId())) {
            $arrData['payment']['auth'] = array(
                    'payTdsTransactionId' => $this->getThreeDSTransactionId(),
                    'payTdsAcquirerId' => $this->getAcquirerId(),
            );
        }

        # If method=CSE a valid payload must be present
        $arrData['payment']['cse'] = $this->getPayload();
        if (empty($arrData['payment']['cse']['data'])) {
            $arrData['payment']['cse'] = array(
                    'data' => $this->getCardData(),
                    'identifier' => $this->getKeyIdentifier(),
            );
        }

        if ($this->getOrderId() != '') {
            $arrData['transaction']['orderId'] = $this->getOrderId();
            $arrData['transaction']['entranceCode'] = $this->getEntranceCode();
        } else {
            $arrData['transaction'] = array_merge($arrData['transaction'], array(
                    'amount' => $this->getAmount(),
                    'finishUrl' => $this->getFinishUrl(),
                    'ipAddress' => $this->getIpAddress(),
                    'currency' => $this->getCurrency(),
                    'description' => $this->getDescription(),
            ));
        }

        return $arrData;
    }
}
