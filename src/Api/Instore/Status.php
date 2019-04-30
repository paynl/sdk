<?php

namespace Paynl\Api\Instore;

use Paynl\Error;

/**
 * Description of Status
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Status extends Instore
{
    /**
     * @var string The hash of the instore transaction
     */
    private $hash;

    /**
     * @param string $hash the hash of the instore transaction
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @inheritdoc
     * @throws Error\Required Hash is required
     */
    protected function getData()
    {
        if (empty($this->hash)) {
            throw new Error\Required('Hash is niet geset');
        }

        $this->data['hash'] = $this->hash;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('instore/status');
    }
}
