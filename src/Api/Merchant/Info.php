<?php

namespace Paynl\Api\Merchant;

class Info extends Merchant
{
    protected $merchantId;

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @inheritdoc
     */
    protected function getData()
    {
        if (!empty($this->merchantId)) {
            $this->data['merchantId'] = $this->merchantId;
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Merchant/info');
    }
}
