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

require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $results = [
      \Paynl\Validate::isPayServerIp('12.34.56.78'), // not a pay server ip
      \Paynl\Validate::isPayServerIp('37.46.137.135'), // pay server ip
    ];

    var_dump($results);
} catch (\Paynl\Error\Error $e) {
    echo "Fout: " . $e->getMessage();
}