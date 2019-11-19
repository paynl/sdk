<?php

namespace PayNL;

// Don't redefine the functions if included multiple times.
if (!\function_exists('PayNL\\GuzzleHttp\\uri_template')) {
    require __DIR__ . '/functions.php';
}
