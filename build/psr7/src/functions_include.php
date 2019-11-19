<?php

namespace PayNL;

// Don't redefine the functions if included multiple times.
if (!\function_exists('PayNL\\GuzzleHttp\\Psr7\\str')) {
    require __DIR__ . '/functions.php';
}
