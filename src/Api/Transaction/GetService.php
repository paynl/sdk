<?php

namespace Paynl\Api\Transaction;

use Paynl\Helper;
use Paynl\Config;

/**
 * Description of GetService
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class GetService extends Transaction
{
    protected $apiTokenRequired = true;
    protected $serviceIdRequired = true;
    protected $version = 16;

    /**
     * @var int The ID of the payment method. Only the payment options linked to the provided payment method ID will be returned if an ID is provided. If omitted, all available payment options are returned. Use the following IDs to filter the options:.
     */
    private $paymentMethodId;

    /**
     * @var array cached result
     */
    private static $cache = array();

    /**
     * @param int $paymentMethodId
     */
    public function setPaymentMethodId($paymentMethodId)
    {
        $this->paymentMethodId = $paymentMethodId;
    }

    /**
     * @inheritdoc
     * @throws \Paynl\Error\Required\ServiceId serviceId is required
     */
    protected function getData()
    {
        Helper::requireServiceId();  

        $this->data['serviceId'] = Config::getServiceId();

        if (!empty($this->paymentMethodId)) {
            $this->data['paymentMethodId'] = $this->paymentMethodId;
        }

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

            if(isset($result['service']) && empty($result['service']['basePath'])) {
              $result['service']['basePath'] = 'https://admin.pay.nl/images';
            }

            self::$cache[$cacheKey] = $result;
        } catch (\Exception $e) {
            self::$cache[$cacheKey] = $e;
            throw $e;
        }

      return $result;
    }
}
