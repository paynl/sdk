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
    $result = \Paynl\Transaction::addRecurring(array(
        'transactionId' => '12345678Xbf1234',
        'amount' => 0.01,
        'description' => 'Your recurring payment',
        'extra1' => 'SDK',
        'extra2' => 'extra2',
        'extra3' => 'extra3'
    ));

    echo $result->getTransactionId();
} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}
