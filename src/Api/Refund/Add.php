<?php

namespace Paynl\Api\Refund;

use Paynl\Helper;
use Paynl\Config;
use Paynl\Error\Required;

/**
 * Api class to refund a transaction
 *
 * @author Chris de Jong <chris@eventix.io>
 */
class Add extends Refund
{
    protected $apiTokenRequired = true;
    protected $serviceIdRequired = true;

    /**
     * @var int the amount in cents
     */
    private $_amount;
    /**
     * @var string the bankAccountHolder
     */
    private $_bankAccountHolder;
    /**
     * @var string the bankAccountNumber
     */
    private $_bankAccountNumber;
    /**
     * @var string the bankAccountBic
     */
    private $_bankAccountBic;
    /**
     * @var string the description for this refund
     */
    private $_description;
    /**
     * @var string additional data promotorId
     */
    private $_promotorId;
    /**
     * @var string additional data tool
     */
    private $_tool;
    /**
     * @var string additional data info
     */
    private $_info;
    /**
     * @var string additional data info
     */
    private $_object;
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
     * @var string the orderId
     */
    private $_orderId;
    /**
     * @var string the currency
     */
    private $_currency;
    /**
     * @var \Datetime the currency
     */
    private $_processDate;

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = (int)$amount;
    }

    /**
     * @param string $bankAccountHolder
     */
    public function setBankAccountHolder($bankAccountHolder)
    {
        $this->_bankAccountHolder = $bankAccountHolder;
    }

    /**
     * @param string $bankAccountNumber
     */
    public function setBankAccountNumber($bankAccountNumber)
    {
        $this->_bankAccountNumber = $bankAccountNumber;
    }

    /**
     * @param string $bankAccountBic
     */
    public function setBankAccountBic($bankAccountBic)
    {
        $this->_bankAccountBic = $bankAccountBic;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @param $promotorId
     */
    public function setPromotorId($promotorId)
    {
        $this->_promotorId = $promotorId;
    }

    /**
     * @param $tool
     */
    public function setTool($tool)
    {
        $this->_tool = $tool;
    }

    /**
     * @param $info
     */
    public function setInfo($info)
    {
        $this->_info = $info;
    }

    /**
     * @param $object
     */
    public function setObject($object)
    {
        $this->_object = $object;
    }

    /**
     * @param $extra1
     */
    public function setExtra1($extra1)
    {
        $this->_extra1 = $extra1;
    }

    /**
     * @param $extra2
     */
    public function setExtra2($extra2)
    {
        $this->_extra2 = $extra2;
    }

    /**
     * @param $extra3
     */
    public function setExtra3($extra3)
    {
        $this->_extra3 = $extra3;
    }

    /**
     * @param $orderId
     */
    public function setOrderId($orderId)
    {
        $this->_orderId = $orderId;
    }

    /**
     * @param $currency
     */
    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    /**
     * @param \DateTime $processDate
     */
    public function setProcessDate(\DateTime $processDate)
    {
        $this->_processDate = $processDate;
    }

    /**
     * Get data to send to the api
     *
     * @return array
     * @throws Required serviceId via config
     * @throws Required _amount Amount is not set
     * @throws Required _bankAccountHolder bankAccountHolder is not set
     * @throws Required _bankAccountNumber bankAccountNumber is not set
     */
    protected function getData()
    {
        Helper::requireServiceId();
        if (empty($this->_amount)) {
            throw new Required('Amount is not set', 1);
        }
        if (empty($this->_bankAccountHolder)) {
            throw new Required('bankAccountHolder is not set', 1);
        }
        if (empty($this->_bankAccountNumber)) {
            throw new Required('bankAccountNumber is not set', 1);
        }

        $this->data['serviceId'] = Config::getServiceId();
        $this->data['amount'] = $this->_amount;
        $this->data['bankAccountHolder'] = $this->_bankAccountHolder;
        $this->data['bankAccountNumber'] = $this->_bankAccountNumber;

        if (!empty($this->_bankAccountBic)) {
            $this->data['bankAccountBic'] = $this->_bankAccountBic;
        }
        if (!empty($this->_description)) {
            $this->data['description'] = $this->_description;
        }
        if (!empty($this->_promotorId)) {
            $this->data['promotorId'] = $this->_promotorId;
        }
        if (!empty($this->_info)) {
            $this->data['info'] = $this->_info;
        }
        if (!empty($this->_tool)) {
            $this->data['tool'] = $this->_tool;
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
        if (isset($this->_orderId)) {
            $this->data['orderId'] = $this->_orderId;
        }
        if (isset($this->_currency)) {
            $this->data['currency'] = $this->_currency;
        }
        if ($this->_processDate instanceof \Datetime) {
            $this->data['processDate'] = $this->_processDate->format('d-m-Y');
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Refund/add');
    }
}
