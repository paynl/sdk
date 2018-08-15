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

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Description of Start
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Start extends Result
{
    /**
     * @return string The transactionId
     */
    public function getTransactionId()
    {
        return $this->data['transaction']['transactionId'];
    }

    /**
     * @return string The url where the customer can complete the payment
     */
    public function getRedirectUrl()
    {
        return $this->data['transaction']['paymentURL'];
    }

    /**
     * @return string The payment reference (for manual transfer)
     */
    public function getPaymentReference()
    {
        return $this->data['transaction']['paymentReference'];
    }
}
