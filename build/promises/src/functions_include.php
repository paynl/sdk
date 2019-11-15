<?php

namespace PayNL;

// Don't redefine the functions if included multiple times.
if (!\function_exists('PayNL\\GuzzleHttp\\Promise\\promise_for')) {
    require __DIR__ . '/functions.php';
}
