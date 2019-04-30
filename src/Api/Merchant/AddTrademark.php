<?php

namespace Paynl\Api\Merchant;

use Paynl\Error;

class AddTrademark extends Merchant
{
    protected $trademark;

    /**
     * @param string $trademark
     */
    public function setTrademark($trademark)
    {
        $this->trademark = $trademark;
    }

    /**
     * @inheritdoc
     */
    protected function getData()
    {
        if (empty($this->trademark)) {
            throw new Error\Required('Trade Name is required');
        }
        $this->data['trademark'] = $this->trademark;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Merchant/addTrademark');
    }
}
