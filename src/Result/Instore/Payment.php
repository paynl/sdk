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

namespace Paynl\Result\Instore;

use Paynl\Result\Result;

/**
 * Result class for instore payment
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Payment extends Result
{
    /**
     * @return string The transaction id
     */
    public function getTransactionId()
    {
        return $this->data['transaction']['transactionId'];
    }

    /**
     * @return mixed The terminal hash for this transaction, use this for Instore::Status
     */
    public function getHash()
    {
        return $this->data['transaction']['terminalHash'];
    }

    /**
     * @return string The url to the status page
     */
    public function getRedirectUrl()
    {
        return $this->data['transaction']['issuerUrl'];
    }
}
