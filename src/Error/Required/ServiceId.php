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

namespace Paynl\Error\Required;

use \Paynl\Error\Required;

/**
 * Thrown when serviceId is missing
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class ServiceId extends Required
{
    public function __construct($message = null, $code = null, $previous = null)
    {
        parent::__construct('No Service id is set, use \\Paynl\\Config::setServiceId() to set the Service id');
    }

}
