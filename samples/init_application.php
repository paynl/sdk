<?php

declare(strict_types=1);

require_once  __DIR__ . '/../vendor/autoload.php';

use PayNL\Sdk\{
    Application\Application,
    Config\Config,
    Response\ResponseInterface
};

if (false === function_exists('print_response')) {
    /**
     * Function to quickly "dump" the response given by exporting
     * the body to a string
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    function print_response(ResponseInterface $response) {
        echo '<pre>' . PHP_EOL .
            var_export($response->getBody(), true) . PHP_EOL .
            '</pre>' . PHP_EOL
        ;
    }
}

$config = new Config(require 'config.php');

return Application::init($config);
