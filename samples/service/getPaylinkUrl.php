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
    $url = \Paynl\Service::getPayLinkUrl(array(
        /**
         * securityMode:
         * 0: no checks (only minimum amount)
         * 1: amount cannot be changed
         * 2: prefilled extra variables cannot be changed, empty variables can be removed
         * 3: prefilled extra variables cannot be changed, empty variables cannot be removed
         */
        'securityMode' => 3,
        'amount' => 10,
        'amountMin' => 0,

        'countryCode' => 'nl',
        'language' => 'nl',

        'extra1' => array(
            'name' => 'Customer Id',
            'value' => '12345678'
        ),
        'extra2' => array(
            'name' => 'Email',
            'value' => '' //if you leave the value empty, the customer can fill in the value
        ),
        'extra3' => array(
            'name' => 'Phone',
            'value' => '0612345678'
        ),
        /**
         * Extra stats data
         */
        'tool' => 'tool',
        'info' => 'info'
    ));

    echo $url;
} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}
