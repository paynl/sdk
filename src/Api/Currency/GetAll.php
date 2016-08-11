<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 6-7-16
 * Time: 17:57
 */

namespace Paynl\Api\Currency;


class GetAll extends Currency
{
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Currency/getAll', $version);
    }
}