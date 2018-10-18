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

namespace Paynl\Result;

/**
 * Base class for the results of the API
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Result
{
    protected $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getRequest()
    {
        return $this->data['request'];
    }

    /**
     * Get the complete result as an array
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
