<?php
declare(strict_types=1);

?>
<html>
    <head>
        <title>Samples</title>
        <style>
            div {
                display: block;
                position: relative;
                float: left;
                margin: 5px 0;
                width: 100%;
            }
            div#main {

            }
        </style>
    </head>
    <body>
        <div id="main">
            <h1>Samples</h1>
            <h2>Currencies</h2>
            <div>
                <a href="currencies/get-all.php" target="_blank">Get all currencies</a>
            </div>
            <div>
                <a href="currencies/get.php" target="_blank">Get currency</a>
            </div>
            <h2>Invoices</h2>
<!--            <div>-->
<!--                <a href="invoices/index.php" target="_blank">Invoices</a>-->
<!--            </div>-->
            <h2>Merchants</h2>
            <h2>Refunds</h2>
            <h2>Services</h2>
            <h2>Statistics</h2>
            <h2>Terminals</h2>
            <h2>Transactions</h2>
            <div>
                <a href="transactions/get-all.php" target="_blank">Get Transactions</a>
            </div>
            <div>
                <a href="transactions/get.php" target="_blank">Get a Transaction</a>
            </div>
            <div>
                <a href="transactions/get-receipt.php" target="_blank">Get Transaction receipt</a>
            </div>
            <div>
                <a href="transactions/create.php" target="_blank">Create a Transaction</a>
            </div>
            <div>
                <a href="transactions/approve.php" target="_blank">Approve a Transaction</a>
            </div>
        </div>
    </body>
</html>
