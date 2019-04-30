<?php

namespace Paynl\Api\Transaction;

use Paynl\Helper;
use Paynl\Config;

/**
 * Description of GetService
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class GetService extends Transaction
{
    protected $apiTokenRequired = true;
    protected $serviceIdRequired = true;

    /**
     * @var array cached result
     */
    private static $cache = array();

    /**
     * @inheritdoc
     * @throws \Paynl\Error\Required\ServiceId serviceId is required
     */
    protected function getData()
    {
        Helper::requireServiceId();

        $this->data['serviceId'] = Config::getServiceId();

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        Helper::requireApiToken();
        Helper::requireServiceId();

        $cacheKey = Config::getTokenCode().'|'.Config::getApiToken() . '|' . Config::getServiceId();
        if (isset(self::$cache[$cacheKey])) {
            if (self::$cache[$cacheKey] instanceof \Exception) {
                throw self::$cache[$cacheKey];
            }
            return self::$cache[$cacheKey];
        }
        try {
            $result = parent::doRequest('transaction/getService');
            self::$cache[$cacheKey] = $result;
        } catch (\Exception $e) {
            self::$cache[$cacheKey] = $e;
            throw $e;
        }
        return $result;
    }
}
