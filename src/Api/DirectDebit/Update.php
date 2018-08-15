<?php

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

class Update extends DirectDebit
{
    protected $apiTokenRequired = true;

    /**
     * @var string The mandateId of the directdebit
     */
    private $_mandateId;
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
     * @var \Datetime Date on which the directdebit needs to be processed.
     */
    private $_processDate;
    /**
     * @var integer Need for recurring part, if intervalValue is 2 and intervalPeriod is 1 than process the directdebit every two weeks.
     */
    private $_intervalValue;
    /**
     * @var integer 1 : Week, 2 : Month, 3: Quarter, 4 : Half year, 5: Year, 6: Day
     */
    private $_intervalPeriod;
    /**
     * @var integer Indicated the number of times this order should be executed.
     */
    private $_intervalQuantity;
    /**
     * @var string First description to include with the payment.
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
     * @param string $mandateId The mandateId of the directdebit.
     */
    public function setMandateId($mandateId)
    {
        $this->_mandateId = $mandateId;
    }

    /**
     * @param int $amount The amount to be paid should be given in cents. For example € 3.50 becomes 350.
     */
    public function setAmount($amount)
    {
        $this->_amount = (int)$amount;
    }

    /**
     * @param string $bankaccountHolder The name of the customer.
     */
    public function setBankaccountHolder($bankaccountHolder)
    {
        $this->_bankaccountHolder = $bankaccountHolder;
    }

    /**
     * @param string $bankaccountNumber The bankaccount number of the customer.
     */
    public function setBankaccountNumber($bankaccountNumber)
    {
        $this->_bankaccountNumber = $bankaccountNumber;
    }

    /**
     * @param string $bankaccountBic The BIC of the bank.
     */
    public function setBankaccountBic($bankaccountBic)
    {
        $this->_bankaccountBic = $bankaccountBic;
    }

    /**
     * @param \DateTime $processDate Date on which the directdebit needs to be processed.
     */
    public function setProcessDate(\DateTime $processDate)
    {
        $this->_processDate = $processDate;
    }

    /**
     * @param integer $intervalValue Need for recurring part, if intervalValue is 2 and intervalPeriod is 1 than process the directdebit every two weeks.
     */
    public function setIntervalValue($intervalValue)
    {
        $this->_intervalValue = $intervalValue;
    }

    /**
     * @param int $intervalPeriod 1 : Week, 2 : Month, 3: Quarter, 4 : Half year, 5: Year, 6: Day
     */
    public function setIntervalPeriod($intervalPeriod)
    {
        $this->_intervalPeriod = $intervalPeriod;
    }

    /**
     * @param int $intervalQuantity Indicated the number of times this order should be executed.
     */
    public function setIntervalQuantity($intervalQuantity)
    {
        $this->_intervalQuantity = $intervalQuantity;
    }

    /**
     * @param string $description First description to include with the payment.
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @param string $ipAddress The IP address of the customer.
     */
    public function setIpAddress($ipAddress)
    {
        $this->_ipAddress = $ipAddress;
    }

    /**
     * @param string $email The email address of the customer.
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @param int $promotorId The ID of the webmaster / promotor.
     */
    public function setPromotorId($promotorId)
    {
        $this->_promotorId = (int)$promotorId;
    }

    /**
     * @param string $tool The used tool code.
     */
    public function setTool($tool)
    {
        $this->_tool = $tool;
    }

    /**
     * @param string $info The used info code.
     */
    public function setInfo($info)
    {
        $this->_info = $info;
    }

    /**
     * @param string $object The used object
     */
    public function setObject($object)
    {
        $this->_object = $object;
    }

    /**
     * @param string $extra1 The first free value.
     */
    public function setExtra1($extra1)
    {
        $this->_extra1 = $extra1;
    }

    /**
     * @param string $extra2  The second free value.
     */
    public function setExtra2($extra2)
    {
        $this->_extra2 = $extra2;
    }

    /**
     * @param string $extra3 The third free value.
     */
    public function setExtra3($extra3)
    {
        $this->_extra3 = $extra3;
    }

    /**
     * @inheritdoc
     * @throws Required mandateId is required
     */
    protected function getData()
    {
        if (empty($this->_mandateId)) {
            throw new Required('mandateId');
        }

        $this->data['mandateId'];

        if (!empty($this->_amount)) {
            $this->data['amount'] = $this->_amount;
        }
        if (!empty($this->_bankaccountHolder)) {
            $this->data['bankaccountHolder'] = $this->_bankaccountHolder;
        }
        if (!empty($this->_bankaccountNumber)) {
            $this->data['bankaccountNumber'] = $this->_bankaccountNumber;
        }
        if (!empty($this->_bankaccountBic)) {
            $this->data['bankaccountBic'] = $this->_bankaccountBic;
        }
        if ($this->_processDate instanceof \DateTime) {
            $this->data['processDate'] = $this->_processDate->format('d-m-Y');
        }
        if (!empty($this->_intervalValue)) {
            $this->data['intervalValue'] = $this->_intervalValue;
        }
        if (!empty($this->_intervalPeriod)) {
            $this->data['intervalPeriod'] = $this->_intervalPeriod;
        }
        if (!empty($this->_intervalQuantity)) {
            $this->data['intervalQuantity'] = $this->_intervalQuantity;
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

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = '', $version = null)
    {
        return parent::doRequest('DirectDebit/update');
    }
}
