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

\Paynl\Config::setApiToken('e41f83b246b706291ea9ad798ccfd9f0fee5e0ab');

$transactionId = $_GET['transactionId']; // The transactionId you get from transaction/start
$terminalId = $_GET['terminalId']; // the terminalId you get from getAllTerminals

try{
    $result = \Paynl\Instore::payment(array(
        'transactionId' => $transactionId,
        'terminalId' => $terminalId
    ));

    header('location: '.$result->getRedirectUrl());
} catch (Paynl\Error\Api $e){
    echo 'Fout: '.$e->getMessage();
}
