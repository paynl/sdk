<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 7-7-16
 * Time: 15:51
 */

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

class RecurringGet extends DirectDebit
{
    protected $apiTokenRequired = true;

    /**
     * @var string The mandate id (IO-xxxx-xxxx-xxxx)
     */
    private $_mandateId;

    /**
     * @param string $mandateId The mandate id (IO-xxxx-xxxx-xxxx)
     */
    public function setMandateId($mandateId)
    {
        $this->_mandateId = $mandateId;
    }

    public function getData()
    {
        if(empty($this->_mandateId)){
            throw new Required('mandateId');
        }

        $this->data['mandateId'] = $this->_mandateId;

        return parent::getData();
    }

    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/recurringGet');
    }
}