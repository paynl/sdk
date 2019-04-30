<?php

namespace Paynl\Api\Transaction;

use Paynl\Config;
use Paynl\Error\Error;
use Paynl\Error\Required;
use Paynl\Helper;

/**
 * Api class to start a new transaction
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Start extends Transaction
{
    protected $apiTokenRequired = true;
    protected $serviceIdRequired = true;

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
     * @var string Your order number
     */
    private $_orderNumber;
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
     * @var string
     */
    private $_transferType;
    /**
     * @var string
     */
    private $_transferValue;
    /**
     * @var string the ipaddress of the enduser, used for fraud detecion
     */
    private $_ipaddress;

    /**
     * @var \DateTime
     */
    private $_invoiceDate;
    /**
     * @var \DateTime
     */
    private $_deliveryDate;

    /**
     * @var array the products for the order
     */
    private $_products = array();

    /**
     * @var \DateTime
     */
    private $_expireDate;

    /**
     * @param \DateTime $expireDate
     */
    public function setExpireDate(\DateTime $expireDate)
    {
        $this->_expireDate = $expireDate;
    }

    /**
     * @param \DateTime $invoiceDate
     */
    public function setInvoiceDate(\DateTime $invoiceDate)
    {
        $this->_invoiceDate = $invoiceDate;
    }

    /**
     * @param \DateTime $deliveryDate
     */
    public function setDeliveryDate(\DateTime $deliveryDate)
    {
        $this->_deliveryDate = $deliveryDate;
    }

    public function setIpAddress($ipAddress)
    {
        $this->_ipaddress = $ipAddress;
    }

    public function setPromotorId($promotorId)
    {
        $this->_promotorId = $promotorId;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->_orderNumber = $orderNumber;
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

    public function setTransferType($transferType)
    {
        $this->_transferType = $transferType;
    }

    public function setTransferValue($transferValue)
    {
        $this->_transferValue = $transferValue;
    }

    /**
     * Add a product to an order
     * Attention! This is purely an administrative option, the amount of the order is not modified.
     *
     * @param string $id
     * @param string $description
     * @param string $productType
     * @param int $price
     * @param int $quantity
     * @param int $vatCode
     * @param string $vatPercentage
     *
     * @throws Error
     */
    public function addProduct(
        $id,
        $description,
        $productType,
        $price,
        $quantity,
        $vatCode,
        $vatPercentage
    ) {
        if (! is_numeric($price)) {
            throw new Error('Price must be numeric', 1);
        }
        if (! is_numeric($quantity)) {
            throw new Error('Quantity must be numeric', 1);
        }

        $this->_products[] = array(
            'productId'     => $id,
            'productType'   => $productType,
            //description mag maar 45 chars lang zijn
            'description'   => substr($description, 0, 45),
            'price'         => $price,
            'quantity'      => $quantity * 1,
            'vatCode'       => $vatCode,
            'vatPercentage' => $vatPercentage
        );
    }

    /**
     * Set the enduser data in the following format
     *
     * [
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
     *  address => [
     *      streetName
     *      streetNumber
     *      zipCode
     *      city
     *      countryCode
     *  ]
     *  invoiceAddress => [
     *      initials
     *      lastname
     *      streetName
     *      streetNumber
     *      zipCode
     *      city
     *      countryCode
     *  ]
     * ]
     *
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
     *
     * @throws Error
     */
    public function setAmount($amount)
    {
        if (! is_numeric($amount)) {
            throw new Error('Amount is niet numeriek', 1);
        }
        $this->_amount = $amount;
    }

    public function setPaymentOptionId($paymentOptionId)
    {
        if (! is_numeric($paymentOptionId)) {
            throw new Error('PaymentOptionId is niet numeriek', 1);
        }
        $this->_paymentOptionId = $paymentOptionId;
    }

    public function setPaymentOptionSubId($paymentOptionSubId)
    {
        $this->_paymentOptionSubId = $paymentOptionSubId;
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
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/start');
    }

    /**
     * @inheritdoc
     * @throws Required Amount is required
     * @throws Required FinishUrl is required
     */
    protected function getData()
    {
        // Checken of alle verplichte velden geset zijn
        Helper::requireServiceId();
        if (empty($this->_amount)) {
            throw new Required('Amount is required', 1);
        }
        if (empty($this->_finishUrl)) {
            throw new Required('FinishUrl is required', 1);
        }

        $data['serviceId'] = Config::getServiceId();
        $data['testMode']  = (int)($this->_testMode === true);
        $data['amount']    = $this->_amount;
        $data['finishUrl'] = $this->_finishUrl;


        if (! empty($this->_paymentOptionId)) {
            $data['paymentOptionId'] = $this->_paymentOptionId;
        }
        if (! empty($this->_exchangeUrl)) {
            $data['transaction']['orderExchangeUrl'] = $this->_exchangeUrl;
        }
        if (! empty($this->_orderNumber)) {
            $data['transaction']['orderNumber'] = $this->_orderNumber;
        }
        if (! empty($this->_description)) {
            $data['transaction']['description'] = $this->_description;
        }
        if (isset($this->_currency)) {
            $data['transaction']['currency'] = $this->_currency;
        }
        if (isset($this->_expireDate)) {
            $data['transaction']['expireDate'] = $this->_expireDate->format('d-m-Y H:i:s');
        }
        if (! empty($this->_paymentOptionSubId)) {
            $data['paymentOptionSubId'] = $this->_paymentOptionSubId;
        }

        $data['ipAddress'] = isset($this->_ipaddress) ? $this->_ipaddress : Helper::getIp();

        if (! empty($this->_products)) {
            $data['saleData']['orderData'] = $this->_products;
        }
        if ($this->_deliveryDate instanceof \DateTime) {
            $data['saleData']['deliveryDate'] = $this->_deliveryDate->format('d-m-Y');
        }
        if ($this->_invoiceDate instanceof \DateTime) {
            $data['saleData']['invoiceDate'] = $this->_invoiceDate->format('d-m-Y');
        }

        if (! empty($this->_enduser)) {
            if (isset($this->_enduser['birthDate']) && $this->_enduser['birthDate'] instanceof \DateTime) {
                $this->_enduser['dob'] = $this->_enduser['birthDate']->format('d-m-Y');
                unset($this->_enduser['birthDate']);
            }
            $data['enduser'] = $this->_enduser;
        }

        if (! empty($this->_extra1)) {
            $data['statsData']['extra1'] = $this->_extra1;
        }
        if (! empty($this->_extra2)) {
            $data['statsData']['extra2'] = $this->_extra2;
        }
        if (! empty($this->_extra3)) {
            $data['statsData']['extra3'] = $this->_extra3;
        }
        if (! empty($this->_promotorId)) {
            $data['statsData']['promotorId'] = $this->_promotorId;
        }
        if (! empty($this->_info)) {
            $data['statsData']['info'] = $this->_info;
        }
        if (! empty($this->_tool)) {
            $data['statsData']['tool'] = $this->_tool;
        }
        if (! empty($this->_object)) {
            $data['statsData']['object'] = $this->_object;
        }
        if (! empty($this->_domainId)) {
            $data['statsData']['domain_id'] = $this->_domainId;
        }
        if (! empty($this->_transferData)) {
            $data['statsData']['transferData'] = $this->_transferData;
        }
        if (! empty($this->_transferType)) {
            $data['transferType'] = $this->_transferType;
        }
        if (! empty($this->_transferValue)) {
            $data['transferValue'] = $this->_transferValue;
        }

        $this->data = array_merge($data, $this->data);

        return parent::getData();
    }
}
