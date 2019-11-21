<?php

declare(strict_types=1);

use PayNL\Sdk\Util\Text;

if (false === function_exists('paynl_split_address')) {

    /**
     * @param string $address
     *
     * @return array
     */
    function paynl_split_address(string $address): array
    {
        return (new Text())->splitAddress($address);
    }
}
