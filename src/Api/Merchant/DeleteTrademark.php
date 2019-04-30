<?php

namespace Paynl\Api\Merchant;

use Paynl\Error;

class DeleteTrademark extends Merchant
{
    protected $trademarkId;

    /**
     * @param string $trademarkId
     */
    public function setTrademarkId($trademarkId)
    {
        $this->trademarkId = $trademarkId;
    }

    /**
     * @inheritdoc
     */
    protected function getData()
    {
        if (empty($this->trademarkId)) {
            throw new Error\Required('trademarkId is required');
        }
        $this->data['trademarkId'] = $this->trademarkId;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Merchant/deleteTrademark');
    }
}
