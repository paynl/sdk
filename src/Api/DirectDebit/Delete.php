<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 13-7-16
 * Time: 19:55
 */

namespace Paynl\Api\DirectDebit;


use Paynl\Error\Required;

class Delete extends DirectDebit
{
    /**
     * @var string The mandateId of the directdebit.
     */
    private $_mandateId;

    /**
     * @param string $mandateId The mandateId of the directdebit.
     */
    public function setMandateId($mandateId)
    {
        $this->_mandateId = $mandateId;
    }

    protected function getData()
    {
        if(empty($this->_mandateId)){
            throw new Required('mandateId');
        } else {
            $this->data['mandateId'] = $this->_mandateId;
        }

        return parent::getData();
    }
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/delete');
    }
}