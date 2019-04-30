<?php

namespace Paynl\Api\Instore;

use Paynl\Error;

/**
 * Confirm the payment, and optionally sent the receipt to the enduser
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class ConfirmPayment extends Instore
{
    /**
     * @var string The hash of the transaction
     */
    protected $hash;
    /**
     * @var string The email address of the end-user
     */
    protected $emailAddress;
    /**
     * @var int The language of the email sent
     */
    protected $languageId;

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @param int $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = (int)$languageId;
    }

    /**
     * @inheritdoc
     * @throws Error\Required Hash is required
     */
    protected function getData()
    {
        if (empty($this->hash)) {
            throw new Error\Required('Hash is required');
        }

        $this->data['hash'] = $this->hash;

        if (!empty($this->emailAddress)) {
            $this->data['emailAddress'] = $this->emailAddress;
        }
        if (!empty($this->languageId)) {
            $this->data['languageId'] = $this->languageId;
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('instore/confirmPayment');
    }
}
