<?php
/*
 * Copyright (C) 2015 Andy Pieters <andy@pay.nl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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
    protected $email;

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param int $language
     */
    public function setLanguage($language)
    {
        $this->language = (int)$language;
    }

    /**
     * @var int The language of the email sent
     */
    protected $language;

    /**
     * @return array The data
     * @throws Error\Required
     */
    protected function getData()
    {
        if (empty($this->hash)) {
            throw new Error\Required('Hash is required');
        }
        $this->data['hash'] = $this->hash;

        if (!empty($this->email)) {
            $this->data['email'] = $this->email;
        }
        if (!empty($this->language)) {
            $this->data['language'] = $this->language;
        }

        return parent::getData();
    }


    /**
     * @param null $endpoint
     * @param null $version
     * @return array The result
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('instore/confirmPayment');
    }
}