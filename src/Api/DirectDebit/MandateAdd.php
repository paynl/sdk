<?php

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

    /**
     * @inheritdoc
     */
    public function getData()
    {
        if (!empty($this->_intervalQuantity)) {
            $this->data['intervalQuantity'] = $this->_intervalQuantity;
        }
        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = 'DirectDebit/mandateAdd', $version = null)
    {
        return parent::doRequest($endpoint, $version);
    }
}
