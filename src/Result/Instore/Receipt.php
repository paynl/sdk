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
 * Result class for getTerminals
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Receipt extends Result
{
    public function getReceipt()
    {
        return base64_decode($this->data['receipt']);
    }

    public function getApprovalId()
    {
        return $this->data['approvalId'];
    }

    public function getCardBrandId()
    {
        return $this->data['cardBrandId'];
    }

    public function getCardBrandName()
    {
        return $this->data['cardBrandName'];
    }

    public function getPaymentProfileId()
    {
        return $this->data['paymentProfileId'];
    }

    public function getPaymentProfileName()
    {
        return $this->data['paymentProfileName'];
    }
}
