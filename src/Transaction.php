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

namespace Paynl;

use Paynl\Result;
use Paynl\Helper;
use Paynl\Api\Transaction as Api;

/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Transaction
{

    public static function start($options = array())
    {
        $api = new Api\Start();

        if (isset($options['amount'])) {
            $api->setAmount(round($options['amount'] * 100));
        }
        if (isset($options['currency'])) {
            $api->setCurrency($options['currency']);
        }

        if (isset($options['returnUrl'])) {
            $api->setFinishUrl($options['returnUrl']);
        }

        if (isset($options['exchangeUrl'])) {
            $api->setExchangeUrl($options['exchangeUrl']);
        }

        if (isset($options['paymentMethod']) && !empty($options['paymentMethod'])) {
            $api->setPaymentOptionId($options['paymentMethod']);
        }
        if (isset($options['bank']) && !empty($options['bank'])) {
            $api->setPaymentOptionSubId($options['bank']);
        }

        if (isset($options['description']) && !empty($options['description'])) {
            $api->setDescription($options['description']);
        }

        if (isset($options['testmode']) && $options['testmode'] == 1) {
            $api->setTestMode(true);
        }

        if (isset($options['extra1'])) {
            $api->setExtra1($options['extra1']);
        }
        if (isset($options['extra2'])) {
            $api->setExtra2($options['extra2']);
        }
        if (isset($options['extra3'])) {
            $api->setExtra3($options['extra3']);
        }

        if(isset($options['ipaddress'])){
            $api->setIpAddress($options['ipaddress']);
        }

        if (isset($options['products'])) {
            foreach ($options['products'] as $product) {
                $taxClass = Helper::calculateTaxClass($product['price'],
                        $product['tax']);
                $api->addProduct($product['id'], $product['name'],
                    round($product['price'] * 100), $product['qty'], $taxClass);
            }
        }
        $enduser = array();
        if (isset($options['enduser'])) {
            $enduser = $options['enduser'];
        }
        if (isset($options['language'])) {
            $enduser['language'] = $options['language'];
        }
        if (isset($options['address'])) {
            $address = array();
            if (isset($options['address']['streetName'])) {
                $address['streetName'] = $options['address']['streetName'];
            }
            if (isset($options['address']['houseNumber'])) {
                $address['streetNumber'] = $options['address']['houseNumber'];
            }
            if (isset($options['address']['zipCode'])) {
                $address['zipCode'] = $options['address']['zipCode'];
            }
            if (isset($options['address']['city'])) {
                $address['city'] = $options['address']['city'];
            }
            if (isset($options['address']['country'])) {
                $address['countryCode'] = $options['address']['country'];
            }
            $enduser['address'] = $address;
        }
        if (isset($options['invoiceAddress'])) {
            $invoiceAddress = array();

            if (isset($options['invoiceAddress']['initials'])) {
                $invoiceAddress['initials'] = $options['invoiceAddress']['initials'];
            }
            if (isset($options['invoiceAddress']['lastName'])) {
                $invoiceAddress['lastName'] = $options['invoiceAddress']['lastName'];
            }
            if (isset($options['invoiceAddress']['streetName'])) {
                $invoiceAddress['streetName'] = $options['invoiceAddress']['streetName'];
            }
            if (isset($options['invoiceAddress']['houseNumber'])) {
                $invoiceAddress['streetNumber'] = $options['invoiceAddress']['houseNumber'];
            }
            if (isset($options['invoiceAddress']['zipCode'])) {
                $invoiceAddress['zipCode'] = $options['invoiceAddress']['zipCode'];
            }
            if (isset($options['invoiceAddress']['city'])) {
                $invoiceAddress['city'] = $options['invoiceAddress']['city'];
            }
            if (isset($options['invoiceAddress']['country'])) {
                $invoiceAddress['countryCode'] = $options['invoiceAddress']['country'];
            }

            $enduser['invoiceAddress'] = $invoiceAddress;
        }
        if (!empty($enduser)) {
            $api->setEnduser($enduser);
        }

        $result = $api->doRequest();


        return new Result\Start($result);
    }

    /**
     * Get the transaction
     *
     * @param string $transactionId
     * @return \Paynl\Result\Transaction
     */
    public static function get($transactionId)
    {
        $api                     = new Api\Info();
        $api->setTransactionId($transactionId);
        $result                  = $api->doRequest();
        $result['transactionId'] = $transactionId;
        return new Result\Transaction($result);
    }

    /**
     * Get the transaction in an exchange script.
     * This will automaticly load orderId from the get string to fetch the transaction
     *
     * @return \Paynl\Result\Transaction
     */
    public static function getForReturn()
    {
        $transactionId = $_GET['orderId'];
        return self::get($transactionId);
    }

    /**
     * Get the transaction in an exchange script.
     * This will work for all kinds of exchange calls (GET, POST AND POST_XML)
     *
     * @return \Paynl\Result\Transaction
     */
    public static function getForExchange()
    {
        if (isset($_GET['order_id'])) {
            $transactionId = $_GET['order_id'];
        } elseif (isset($_POST['order_id'])) {
            $transactionId = $_POST['order_id'];
        } else {
            // maybe its xml
            $input = file_get_contents('php://input');
            $xml   = simplexml_load_string($input);

            $transactionId = $xml->order_id;
        }

        return self::get($transactionId);
    }

    public static function refund($transactionId, $amount = null,
                                  $description = null)
    {
        $api = new Api\Refund();
        $api->setTransactionId($transactionId);
        if (!is_null($amount)) {
            $amount = round($amount * 100);
            $api->setAmount($amount);
        }

        if (!is_null($description)) {
            $api->setDescription($description);
        }
        $result = $api->doRequest();
    }
}