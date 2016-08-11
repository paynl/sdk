<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 6-7-16
 * Time: 18:06
 */

namespace Paynl\Error;


class NotFound extends Error
{

    public function __construct($objectName, $identifier, Exception $previous = null)
    {
        $message = "$objectName: '$identifier' Not found";
        parent::__construct($message, 404, $previous);
    }

}