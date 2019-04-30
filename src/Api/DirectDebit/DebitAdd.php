<?php

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

/**
 * @author Andy Pieters <andy@pay.nl>
 */
class DebitAdd extends DirectDebit
{
    /**
     * @var bool Is the ApiToken required for this API
     */
    protected $apiTokenRequired = true;
    /**
     * @var bool Is the serviceId required for this API
     */
    protected $serviceIdRequired = true;

    /**
     * @var integer The amount to be paid should be given in cents. For example € 3.50 becomes 350.
     */
    private $_amount;
    /**
     * @var string The name of the customer.
     */
    private $_bankaccountHolder;
    /**
     * @var string The bankaccount number of the customer.
     */
    private $_bankaccountNumber;
    /**
     * @var string The BIC of the bank.
     */
    private $_bankaccountBic;
    /**
     * @var \DateTime Date on which the directdebit needs to be processed.
     */
    private $_processDate;
    /**
     * @var string Description to include with the payment.
     */
    private $_description;
    /**
     * @var string The IP address of the customer.
     */
    private $_ipAddress;
    /**
     * @var string The email address of the customer.
     */
    private $_email;
    /**
     * @var integer The ID of the webmaster / promotor.
     */
    private $_promotorId;
    /**
     * @var string The used tool code.
     */
    private $_tool;
    /**
     * @var string The used info code.
     */
    private $_info;
    /**
     * @var string The used object.
     */
    private $_object;
    /**
     * @var string The first free value.
     */
    private $_extra1;
    /**
     * @var string The second free value.
     */
    private $_extra2;
    /**
     * @var string The third free value.
     */
    private $_extra3;
    /**
     * @var string The currency of the amount. Default is EUR.
     */
    private $_currency;
    /**
     * @var string Yes    The exchange URL for this order.
     */
    private $_exchangeUrl;

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = round($amount);
    }

    /**
     * @param string $bankaccountHolder
     */
    public function setBankaccountHolder($bankaccountHolder)
    {
        $this->_bankaccountHolder = $bankaccountHolder;
    }

    /**
     * @param string $bankaccountNumber
     */
    public function setBankaccountNumber($bankaccountNumber)
    {
        $this->_bankaccountNumber = $bankaccountNumber;
    }

    /**
     * @param string $bankaccountBic
     */
    public function setBankaccountBic($bankaccountBic)
    {
        $this->_bankaccountBic = $bankaccountBic;
    }

    /**
     * @param \DateTime $processDate
     */
    public function setProcessDate(\DateTime $processDate)
    {
        $this->_processDate = $processDate;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->_ipAddress = $ipAddress;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @param int $promotorId
     */
    public function setPromotorId($promotorId)
    {
        $this->_promotorId = (int)$promotorId;
    }

    /**
     * @param string $tool
     */
    public function setTool($tool)
    {
        $this->_tool = $tool;
    }

    /**
     * @param string $info
     */
    public function setInfo($info)
    {
        $this->_info = $info;
    }

    /**
     * @param string $object
     */
    public function setObject($object)
    {
        $this->_object = $object;
    }

    /**
     * @param string $extra1
     */
    public function setExtra1($extra1)
    {
        $this->_extra1 = $extra1;
    }

    /**
     * @param string $extra2
     */
    public function setExtra2($extra2)
    {
        $this->_extra2 = $extra2;
    }

    /**
     * @param string $extra3
     */
    public function setExtra3($extra3)
    {
        $this->_extra3 = $extra3;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    /**
     * @param string $exchangeUrl
     */
    public function setExchangeUrl($exchangeUrl)
    {
        $this->_exchangeUrl = $exchangeUrl;
    }

    /**
     * @inheritdoc
     * @throws Required amount is required
     * @throws Required bankaccountHolder is required
     * @throws Required bankaccountnumber is required
     */
    public function getData()
    {
        if (empty($this->_amount)) {
            throw new Required('amount is required');
        }
        if (empty($this->_bankaccountHolder)) {
            throw new Required('bankaccountHolder is required');
        }
        if (empty($this->_bankaccountNumber)) {
            throw new Required('bankaccountnumber is required');
        }

        $this->data['amount'] = $this->_amount;
        $this->data['bankaccountHolder'] = $this->_bankaccountHolder;
        $this->data['bankaccountnumber'] = $this->_bankaccountNumber;

        if (!empty($this->_bankaccountBic)) {
            $this->data['bankaccountBic'] = $this->_bankaccountBic;
        }
        if ($this->_processDate instanceof \DateTime) {
            $this->data['processDate'] = $this->_processDate->format('d-m-Y');
        }
        if (!empty($this->_description)) {
            $this->data['description'] = $this->_description;
        }
        if (!empty($this->_ipAddress)) {
            $this->data['ipAddress'] = $this->_ipAddress;
        }
        if (!empty($this->_email)) {
            $this->data['email'] = $this->_email;
        }
        if (!empty($this->_promotorId)) {
            $this->data['promotorId'] = $this->_promotorId;
        }
        if (!empty($this->_tool)) {
            $this->data['tool'] = $this->_tool;
        }
        if (!empty($this->_info)) {
            $this->data['info'] = $this->_info;
        }
        if (!empty($this->_object)) {
            $this->data['object'] = $this->_object;
        }
        if (!empty($this->_extra1)) {
            $this->data['extra1'] = $this->_extra1;
        }
        if (!empty($this->_extra2)) {
            $this->data['extra2'] = $this->_extra2;
        }
        if (!empty($this->_extra3)) {
            $this->data['extra3'] = $this->_extra3;
        }
        if (!empty($this->_currency)) {
            $this->data['currency'] = $this->_currency;
        }
        if (!empty($this->_exchangeUrl)) {
            $this->data['exchangeUrl'] = $this->_exchangeUrl;
        }

        return parent::getData();
    }

    /**
     * @param string $endpoint
     * @param int|null $version
     * @return array The result
     */
    public function doRequest($endpoint = 'DirectDebit/debitAdd', $version = null)
    {
        if ($version === null) {
            $version = $this->version;
        }
        return parent::doRequest($endpoint, $version);
    }
}
