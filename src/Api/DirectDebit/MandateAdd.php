<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 6-7-16
 * Time: 16:06
 */

namespace Paynl\Api\DirectDebit;


class MandateAdd extends DebitAdd
{
    /**
     * @var integer Indicated the number of times this order should be executed.
     */
    private $_intervalQuantity;

    /**
     * @param int $intervalQuantity Indicated the number of times this order should be executed.
     */
    public function setIntervalQuantity($intervalQuantity)
    {
        $this->_intervalQuantity = $intervalQuantity;
    }

    public function getData()
    {
        if(!empty($this->_intervalQuantity)){
            $this->data['intervalQuantity'] = $this->_intervalQuantity;
        }
        return parent::getData();
    }

    public function doRequest($endpoint = 'DirectDebit/mandateAdd', $version = null)
    {
        return parent::doRequest($endpoint, $version);
    }
}