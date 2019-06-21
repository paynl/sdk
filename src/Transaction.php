<?php

namespace Paynl;

use Paynl\Api\Transaction as Api;
use Paynl\Result\Transaction as Result;

/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Transaction
{
    /** @var string Arikel / product */
    const PRODUCT_TYPE_ARTICLE = 'ARTICLE';
    /** @var string Hoog risico product (mobiele telefoon, laptop) */
    const PRODUCT_TYPE_ARTICLE_H = 'ARTICLE_H';
    /** @var string Gratis artikel, welke een waarde vertegenwoordigd */
    const PRODUCT_TYPE_VOUCHER = 'VOUCHER';
    /** @var string Kaart welke eenmalig is in te wisselen (gemiddeld fraude risico) */
    const PRODUCT_TYPE_GIFTCARD = 'GIFTCARD';
    /** @var string Hoger risico digitaal geld (steam/paysafecard etc.) */
    const PRODUCT_TYPE_EMONEY = 'EMONEY';
    /** @var string Opwaarding van een bestaand account/wallet */
    const PRODUCT_TYPE_TOPUP = 'TOPUP';
    /** @var string Digitale waarde, zoals een BitCoin, Litecoin of andere altcoin */
    const PRODUCT_TYPE_CRYPTO = 'CRYPTO';
    /** @var string Betaling ter bevestiging van een extern accounts */
    const PRODUCT_TYPE_IDENTITY = 'IDENTITY';
    /** @var string Betaling van een factuur */
    const PRODUCT_TYPE_INVOICE = 'INVOICE';
    /** @var string Digitale overdracht van een bestand */
    const PRODUCT_TYPE_DOWNLOAD = 'DOWNLOAD';
    /** @var string Digitaal product welke bewaard op de server van de ondernemer (bijvoorbeeld: asset binnen een game) */
    const PRODUCT_TYPE_VIRTUAL = 'VIRTUAL';
    /** @var string Creditfactuur of product (van een eerdere order) */
    const PRODUCT_TYPE_CREDIT = 'CREDIT';
    /** @var string Administratie- of handelingskosten */
    const PRODUCT_TYPE_HANDLING = 'HANDLING';
    /** @var string Betalingskosten */
    const PRODUCT_TYPE_PAYMENT = 'PAYMENT';
    /** @var string Verzendkosten */
    const PRODUCT_TYPE_SHIPPING = 'SHIPPING';
    /** @var string Algemene korting */
    const PRODUCT_TYPE_DISCOUNT = 'DISCOUNT';

    /**
     * Start a new transaction
     *
     * @param array $options
     *
     * @return Result\Start
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function start($options = array())
    {
        $api = new Api\Start();

        if (isset($options['amount'])) {
            $api->setAmount(round($options['amount'] * 100));
        }
        if (isset($options['currency'])) {
            $api->setCurrency($options['currency']);
        }
        if (isset($options['expireDate'])) {
            if (is_string($options['expireDate'])) {
                $options['expireDate'] = new \DateTime($options['expireDate']);
            }
            $api->setExpireDate($options['expireDate']);
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
        if (isset($options['orderNumber']) && !empty($options['orderNumber'])) {
            $api->setOrderNumber($options['orderNumber']);
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
        if (isset($options['ipaddress'])) {
            $api->setIpAddress($options['ipaddress']);
        }
        if (isset($options['invoiceDate'])) {
            if (is_string($options['invoiceDate'])) {
                $options['invoiceDate'] = new \DateTime($options['invoiceDate']);
            }
            $api->setInvoiceDate($options['invoiceDate']);
        }
        if (isset($options['deliveryDate'])) {
            if (is_string($options['deliveryDate'])) {
                $options['deliveryDate'] = new \DateTime($options['deliveryDate']);
            }
            $api->setDeliveryDate($options['deliveryDate']);
        }

        if (isset($options['products'])) {
            foreach ((array)$options['products'] as $product) {
                $taxClass = 'N';
                $taxPercentage = 0;
                if (isset($product['tax'])) {
                    $taxClass = Helper::calculateTaxClass($product['price'], $product['tax']);
                    $taxPercentage = round(Helper::calculateTaxPercentage($product['price'], $product['tax']));
                }

                if (isset($product['vatPercentage']) && is_numeric($product['vatPercentage'])) {
                    $taxPercentage = round($product['vatPercentage'], 2);
                    $taxClass = Helper::calculateTaxClass(100 + $taxPercentage, $taxPercentage);
                }

                if (!isset($product['type'])) {
                    $product['type'] = self::PRODUCT_TYPE_ARTICLE;
                }

                $api->addProduct(
                    $product['id'],
                    $product['name'],
                    $product['type'],
                    round($product['price'] * 100),
                    $product['qty'],
                    $taxClass,
                    $taxPercentage
                );
            }
        }
        $enduser = array();
        if (isset($options['enduser'])) {
            if (isset($options['enduser']['birthDate']) && is_string($options['enduser']['birthDate'])) {
                $options['enduser']['birthDate'] = new \DateTime($options['enduser']['birthDate']);
            }
            $enduser = $options['enduser'];
        }
        if (isset($options['company'])) {
            $enduser['company'] = $options['company'];
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
            if (isset($options['address']['houseNumberExtension'])) {
                $address['streetNumberExtension'] = $options['address']['houseNumberExtension'];
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
            if (isset($options['invoiceAddress']['houseNumberExtension'])) {
                $invoiceAddress['streetNumberExtension'] = $options['invoiceAddress']['houseNumberExtension'];
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
            if (isset($options['invoiceAddress']['gender'])) {
                $invoiceAddress['gender'] = $options['invoiceAddress']['gender'];
            }

            $enduser['invoiceAddress'] = $invoiceAddress;
        }
        if (!empty($enduser)) {
            $api->setEnduser($enduser);
        }

        if (!empty($options['object'])) {
            $api->setObject($options['object']);
        }
        if (!empty($options['tool'])) {
            $api->setTool($options['tool']);
        }
        if (!empty($options['info'])) {
            $api->setInfo($options['info']);
        }

        if (!empty($options['promotorId'])) {
            $api->setPromotorId($options['promotorId']);
        }
        if (isset($options['transferType'])) {
            $api->setTransferType($options['transferType']);
        }
        if (isset($options['transferValue'])) {
            $api->setTransferValue($options['transferValue']);
        }

        $result = $api->doRequest();

        return new Result\Start($result);
    }

    /**
     * Get the transaction in a return script.
     * This will automatically load orderId from the get string to fetch the transaction
     *
     * @return Result\Transaction
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function getForReturn()
    {
        return self::get($_GET['orderId']);
    }

    /**
     * Get the transaction
     *
     * @param string $transactionId
     *
     * @return Result\Transaction
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function get($transactionId)
    {
        $api = new Api\Info();
        $api->setTransactionId($transactionId);
        $result = $api->doRequest();

        $result['transactionId'] = $transactionId;

        return new Result\Transaction($result);
    }

    /**
     * @param $transactionId
     * @return Result\Status
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function status($transactionId)
    {
        $api = new Api\Status();
        $api->setTransactionId($transactionId);
        $result = $api->doRequest();

        return new Result\Status($result);
    }

    /**
     * Get the transaction in an exchange script.
     * This will work for all kinds of exchange calls (GET, POST AND POST_XML)
     *
     * @return Result\Transaction
     * @throws Error\Api
     * @throws Error\Error
     */
    public static function getForExchange()
    {
        if (isset($_GET['order_id'])) {
            return self::get($_GET['order_id']);
        }

        if (isset($_POST['order_id'])) {
            return self::get($_POST['order_id']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            return self::get(json_decode(file_get_contents('php://input'), true)['order_id']);
        }

        // maybe its xml
        $input = file_get_contents('php://input');
        $xml = simplexml_load_string($input);

        return self::get($xml->order_id);
    }

    /**
     * (Partially) Refund a transaction
     * If only the transactionId is supplied, the full amount of transaction will be refunded
     *
     * @param string $transactionId
     * @param int|float|null $amount
     * @param string|null $description
     * @param \DateTime $processDate
     *
     * @return Result\Refund
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function refund(
        $transactionId,
        $amount = null,
        $description = null,
        \DateTime $processDate = null
    )
    {
        $api = new Api\Refund();
        $api->setTransactionId($transactionId);
        if ($amount !== null) {
            $amount = round($amount * 100);
            $api->setAmount($amount);
        }
        if ($description !== null) {
            $api->setDescription($description);
        }
        if ($processDate !== null) {
            $api->setProcessDate($processDate);
        }
        $result = $api->doRequest();

        return new Result\Refund($result);
    }

    /**
     * Charge an existing recurring transaction by its id
     *
     * @param $options array
     * @return Result\ByRecurringId
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function byRecurringId($options)
    {
        $api = new Api\ByRecurringId();

        if (isset($options['recurringId'])) $api->setRecurringId($options['recurringId']);
        if (isset($options['amount'])) $api->setAmount($options['amount']);
        if (isset($options['description'])) $api->setDescription($options['description']);
        if (isset($options['currency'])) $api->setCurrency($options['currency']);
        if (isset($options['cvc'])) $api->setCvc($options['cvc']);
        if (isset($options['statsData']) && is_array($options['statsData'])) $api->setStatsData($options['statsData']);
        $result = $api->doRequest();
        return new Result\ByRecurringId($result);
    }

    /**
     * Approve a transaction that needs to be verified
     * @param $transactionId
     * @return bool
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function approve($transactionId)
    {
        $api = new Api\Approve();
        $api->setTransactionId($transactionId);
        $result = $api->doRequest();

        return $result['request']['result'] == 1;
    }

    /**
     * Decline a transaction that need to be verified
     * @param $transactionId
     * @return bool
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function decline($transactionId)
    {
        $api = new Api\Decline();
        $api->setTransactionId($transactionId);
        $result = $api->doRequest();

        return $result['request']['result'] == 1;
    }

    /**
     * Capture a transaction
     *
     * @param $transactionId
     * @return bool
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function capture($transactionId)
    {
        $api = new Api\Capture();
        $api->setTransactionId($transactionId);
        $result = $api->doRequest();

        return $result['request']['result'] == 1;
    }

    /**
     * Void a transaction
     *
     * @param $transactionId
     * @return bool
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function void($transactionId)
    {
        $api = new Api\VoidTransaction();
        $api->setTransactionId($transactionId);
        $result = $api->doRequest();

        return $result['request']['result'] == 1;
    }

    /**
     * Create a recurring transaction from an existing transaction
     * This is currently only suitable for VISA and MasterCard Ask Pay.nl to activate this option for you.
     *
     * @param array $options An array that contains the following elements: transactionId (required), amount, description, extra1, extra2, extra3
     *
     * @return Result\AddRecurring
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function addRecurring($options = array())
    {
        $api = new Api\AddRecurring();

        if (isset($options['transactionId'])) {
            $api->setTransactionId($options['transactionId']);
        }
        if (isset($options['amount'])) {
            $amount = round($options['amount'] * 100);
            $api->setAmount(round($amount));
        }
        if (isset($options['description'])) {
            $api->setDescription($options['description']);
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
        $result = $api->doRequest();

        return new Result\AddRecurring($result);
    }

    /**
     * Create a external payment
     *
     * @param array $options An array that contains the following elements: transactionId (required), customerId (required), customerName, paymentType
     *
     * @return \Paynl\Result\Transaction\ConfirmExternalPayment
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function confirmExternalPayment($options = array())
    {
        $api = new Api\ConfirmExternalPayment();

        if (isset($options['transactionId'])) {
            $api->setTransactionId($options['transactionId']);
        }

        if (isset($options['customerId'])) {
            $api->setCustomerId($options['customerId']);
        }

        if (isset($options['customerName'])) {
            $api->setCustomerName($options['customerName']);
        }

        if (isset($options['paymentType'])) {
            $api->setPaymentType($options['paymentType']);
        }

        $result = $api->doRequest();

        return new Result\ConfirmExternalPayment($result);
    }

    /**
     * Charge an alipay or wechat account by scanning a qr code
     *
     * @param array $options
     * @return Result\QRPayment
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\InvalidArgument
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    public static function QRPayment($options = array())
    {
        $api = new Api\QRPayment();

        if (isset($options['scanData'])) {
            $api->setScanData($options['scanData']);
        }
        if (isset($options['amount'])) {
            $api->setAmount(round($options['amount'] * 100));
        }
        if (isset($options['description'])) {
            $api->setDescription($options['description']);
        }
        if (isset($options['currency'])) {
            $api->setCurrency($options['currency']);
        }
        if (isset($options['statsData'])) {
            $api->setStatsData($options['statsData']);
        }

        $result = $api->doRequest();

        return new Result\QRPayment($result);
    }
}
