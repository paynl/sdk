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

require_once '../vendor/autoload.php';
require_once 'config.php';

try {
    $transaction = \Paynl\Transaction::getForExchange();

    if ($transaction->isPaid()) {
        // process the payment
    } elseif ($transaction->isCanceled()) {
        // payment canceled, restock items
    }
// always start your response with TRUE|
    echo "TRUE| ";
// Optionally you can send a message after TRUE|, you can view these messages in the logs. https://admin.pay.nl/logs/payment_state
    echo $transaction->isPaid() ? 'Paid' : 'Not paid';
} catch (\Paynl\Error\Error $e) {
    echo "Fout: " . $e->getMessage();
}
