<?php

include "../gateway.php";

use Paynl\SDK\Exception\BadRequestException;
use Paynl\SDK\Exception\NotFoundException;
use Paynl\SDK\Exception\UnprocessableException;


try {
    $transaction = $gateway->transactions()->void('EX-1601-5255-5380');
    echo $transaction;
} catch (BadRequestException $e) {
    echo "Bad request".PHP_EOL;
    echo $e->getMessage();

} catch (NotFoundException $e) {
    echo "Not Found".PHP_EOL;
    echo $e->getMessage();
} catch (UnprocessableException $e) {
    echo "Bad request".PHP_EOL;
    echo $e->getMessage();
}

