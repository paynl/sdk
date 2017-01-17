<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 16-1-17
 * Time: 20:26
 */

namespace Paynl\Api\Service;


use Paynl\Api\Api;

class Service extends Api
{
    protected $apiTokenRequired = true;

    /**
     * @var int the version of the api
     */
    protected $_version = 3;

    /**
     * @param string $endpoint
     * @param int|null $version
     * @return array The result
     */
    public function doRequest($endpoint, $version = null)
    {
        if (is_null($version)) {
            $version = $this->_version;
        }
        return parent::doRequest($endpoint, $version);
    }
}