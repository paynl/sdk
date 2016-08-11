<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 7-7-16
 * Time: 15:56
 */

namespace Paynl\Api\DirectDebit;


class MandateGet extends DirectDebit
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
        $this->data['mandateId'] = $this->_mandateId;

        return parent::getData();
    }

    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/mandateGet');
    }
}