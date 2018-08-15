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
    $transaction = \Paynl\Transaction::getForReturn();


    if ($transaction->isPaid() ||
        $transaction->isPending() //manual transfer transactions are always pending when the user is returned
    ) {
        // redirect to thank you page
        echo "Thank you<br /><a href='transaction/start.php'>New payment</a>";
        if ($transaction->isPaid()) {
            echo "<br /><a href='transaction/refund.php?transactionId=" . $transaction->getId() . "'>Refund</a>";
        }
    } elseif ($transaction->isCanceled()) {
        // redirect back to checkout
        echo "Payment canceled <br /><a href='transaction/start.php'>Try again</a>";
    } elseif ($transaction->isAuthorized()) {
        echo "Payment authorized<br />";
        echo "<a href='transaction/capture.php?transactionId=" . $transaction->getId() . "'>capture</a><br />";
        echo "<a href='transaction/void.php?transactionId=" . $transaction->getId() . "'>void</a>";
    }
} catch (\Paynl\Error\Error $e) {
    echo "Fout: " . $e->getMessage();
}
