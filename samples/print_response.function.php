<?php

use PayNL\Sdk\Response\ResponseInterface;

if (false === function_exists('print_response')) {
    /**
     * Function to quickly "dump" the response given by exporting
     * the body to a string
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    function print_response(ResponseInterface $response)
    {
        echo '<pre>' . PHP_EOL .
            var_export($response->getBody(), true) . PHP_EOL .
            '</pre>' . PHP_EOL
        ;
    }
}
