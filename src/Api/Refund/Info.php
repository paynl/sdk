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

namespace Paynl\Api\Refund;

use Paynl\Error;

/**
 * Description of Info
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Info extends Refund
{
    protected $apiTokenRequired = true;

    /**
     * @var string
     */
    private $refundId;
    /**
     * Set the refundId
     *
     * @param string $refundId
     */
    public function setRefundId($refundId)
    {
        $this->refundId = $refundId;
    }

    /**
     * @inheritdoc
     * @throws Error\Required RefundId is required
     */
    protected function getData()
    {
        if (empty($this->refundId)) {
            throw new Error\Required('RefundId required');
        }

        $this->data['refundId'] = $this->refundId;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('refund/info');
    }
}
