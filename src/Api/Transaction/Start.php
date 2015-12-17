<?php
/*
 * Copyright (C) 2015 Andy Pieters <andy@pay.nl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Paynl\Api\Transaction;

use Paynl\Api\Api;
use Paynl\Helper;
use Paynl\Config;
use Paynl\Error\Required as ErrorRequired;
use Paynl\Error\Error as Error;

/**
 * Api class to start a new transaction
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Start extends Api
{
    /**
     * @var int amount in cents
     */
    private $_amount;
    /**
     * @var int the payment method id
     */
    private $_paymentOptionId;
    /**
     * @var int the bank id
     */
    private $_paymentOptionSubId;
    /**
     * @var string the finish url
     */
    private $_finishUrl;
    /**
     * @var string the currency
     */
    private $_currency;
    /**
     * @var string the exchange url
     */
    private $_exchangeUrl;
    /**
     * @var string the description
     */
    private $_description;
    /**
     * @var array The enduser data
     */
    private $_enduser;
    /**
     * @var string additional data extra1
     */
    private $_extra1;
    /**
     * @var string additional data extra2
     */
    private $_extra2;
    /**
     * @var string additional data extra3
     */
    private $_extra3;
    /**
     * @var bool start transaction in testmode
     */
    private $_testMode = false;
    /**
     * @var string additional data promotorId
     */
    private $_promotorId;
    /**
     * @var string additional data info
     */
    private $_info;
    /**
     * @var string additional data tool
     */
    private $_tool;
    /**
     * @var string additional data info
     */
    private $_object;
    /**
     * @var string additional data domainId
     */
    private $_domainId;
    /**
     * @var string additional data transferData
     */
    private $_transferData;
    /**
     * @var string the ipaddress of the enduser, used for fraud detection
     */
    private $_ipaddress;

    /**
     * @var array the products for the order
     */
    private $_products = array();

    public function setIpAddress($ipAddress)
    {
        $this->_ipaddress = $ipAddress;
    }

    public function setPromotorId($promotorId)
    {
        $this->_promotorId = $promotorId;
    }

    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    public function setInfo($info)
    {
        $this->_info = $info;
    }

    public function setTool($tool)
    {
        $this->_tool = $tool;
    }

    public function setObject($object)
    {
        $this->_object = $object;
    }

    public function setTransferData($transferData)
    {
        $this->_transferData = $transferData;
    }

    /**
     * Add a product to an order
     * Attention! This is purely an adminstrative option, the amount of the order is not modified.
     *
     * @param string $id
     * @param string $description
     * @param int $price
     * @param int $quantity
     * @param int $vatPercentage
     * @throws Error
     */
    public function addProduct($id, $description, $price, $quantity,
                               $vatPercentage)
    {
        if (!is_numeric($price)) {
            throw new Error('Price moet numeriek zijn', 1);
        }
        if (!is_numeric($quantity)) {
            throw new Error('Quantity moet numeriek zijn', 1);
        }

        $quantity = $quantity * 1;

        //description mag maar 45 chars lang zijn
        $description = substr($description, 0, 45);

        $arrProduct = array(
            'productId' => $id,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'vatCode' => $vatPercentage,
        );
        $this->_products[] = $arrProduct;
    }

    /**
     * Set the enduser data in the following format
     *
     * array(
     *  initials
     *  lastName
     *  language
     *  accessCode
     *  gender (M or F)
     *  dob (DD-MM-YYYY)
     *  phoneNumber
     *  emailAddress
     *  bankAccount
     *  iban
     *  bic
     *  sendConfirmMail
     *  confirmMailTemplate
     *  address => array(
     *      streetName
     *      streetNumber
     *      zipCode
     *      city
     *      countryCode
     *  )
     *  invoiceAddress => array(
     *      initials
     *      lastname
     *      streetName
     *      streetNumber
     *      zipCode
     *      city
     *      countryCode
     *  )
     * )
     * @param array $enduser
     */
    public function setEnduser($enduser)
    {
        $this->_enduser = $enduser;
    }

    /**
     * Set the amount(in cents) of the transaction
     *
     * @param int $amount
     * @throws Error
     */
    public function setAmount($amount)
    {
        if (is_numeric($amount)) {
            $this->_amount = $amount;
        } else {
            throw new Error('Amount is niet numeriek', 1);
        }
    }

    public function setPaymentOptionId($paymentOptionId)
    {
        if (is_numeric($paymentOptionId)) {
            $this->_paymentOptionId = $paymentOptionId;
        } else {
            throw new Error('PaymentOptionId is niet numeriek', 1);
        }
    }

    public function setPaymentOptionSubId($paymentOptionSubId)
    {
        if (is_numeric($paymentOptionSubId)) {
            $this->_paymentOptionSubId = $paymentOptionSubId;
        } else {
            throw new Error('PaymentOptionSubId is niet numeriek', 1);
        }
    }

    /**
     * Set the url where the user will be redirected to after payment.
     *
     * @param string $finishUrl
     */
    public function setFinishUrl($finishUrl)
    {
        $this->_finishUrl = $finishUrl;
    }

    /**
     * Set the communication url, the pay.nl server will call this url when the status of the transaction changes
     *
     * @param string $exchangeUrl
     */
    public function setExchangeUrl($exchangeUrl)
    {
        $this->_exchangeUrl = $exchangeUrl;
    }

    public function setTestMode($testmode)
    {
        $this->_testMode = (bool)$testmode;
    }

    public function setExtra1($extra1)
    {
        $this->_extra1 = $extra1;
    }

    public function setExtra2($extra2)
    {
        $this->_extra2 = $extra2;
    }

    public function setExtra3($extra3)
    {
        $this->_extra3 = $extra3;
    }

    public function setDomainId($domainId)
    {
        $this->_domainId = $domainId;
    }

    /**
     * Set the description for the transaction
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    protected function getData()
    {
        // Checken of alle verplichte velden geset zijn      
        Helper::requireServiceId();

        $data['serviceId'] = Config::getServiceId();

        if ($this->_testMode === true) {
            $data['testMode'] = '1';
        } else {
            $data['testMode'] = '0';
        }

        if (empty($this->_amount)) {
            throw new ErrorRequired('Amount is niet geset', 1);
        } else {
            $data['amount'] = $this->_amount;
        }


        if (!empty($this->_paymentOptionId)) {
            $data['paymentOptionId'] = $this->_paymentOptionId;
        }
        if (empty($this->_finishUrl)) {
            throw new ErrorRequired('FinishUrl is niet geset', 1);
        } else {
            $data['finishUrl'] = $this->_finishUrl;
        }
        if (!empty($this->_exchangeUrl)) {
            $data['transaction']['orderExchangeUrl'] = $this->_exchangeUrl;
        }

        if (!empty($this->_description)) {
            $data['transaction']['description'] = $this->_description;
        }
        if (isset($this->_currency)) {
            $data['transaction']['currency'] = $this->_currency;
        }

        if (!empty($this->_paymentOptionSubId)) {
            $data['paymentOptionSubId'] = $this->_paymentOptionSubId;
        }


        if (isset($this->_ipaddress)) {
            $data['ipAddress'] = $this->_ipaddress;
        } else {
            $data['ipAddress'] = Helper::getIp();
        }

        if (!empty($this->_products)) {
            $data['saleData']['orderData'] = $this->_products;
        }

        if (!empty($this->_enduser)) {
            $data['enduser'] = $this->_enduser;
        }

        if (!empty($this->_extra1)) {
            $data['statsData']['extra1'] = $this->_extra1;
        }
        if (!empty($this->_extra2)) {
            $data['statsData']['extra2'] = $this->_extra2;
        }
        if (!empty($this->_extra3)) {
            $data['statsData']['extra3'] = $this->_extra3;
        }
        if (!empty($this->_promotorId)) {
            $data['statsData']['promotorId'] = $this->_promotorId;
        }
        if (!empty($this->_info)) {
            $data['statsData']['info'] = $this->_info;
        }
        if (!empty($this->_tool)) {
            $data['statsData']['tool'] = $this->_tool;
        }
        if (!empty($this->_object)) {
            $data['statsData']['object'] = $this->_object;
        }
        if (!empty($this->_domainId)) {
            $data['statsData']['domain_id'] = $this->_domainId;
        }
        if (!empty($this->_transferData)) {
            $data['statsData']['transferData'] = $this->_transferData;
        }

        $this->data = array_merge($data, $this->data);

        return parent::getData();
    }

    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/start');
    }
}