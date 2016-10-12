<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 6-7-16
 * Time: 18:22
 */

namespace Paynl\Result\DirectDebit\Recurring;


use Paynl\Result\Result;

class Add extends Result
{
    public function getMandateId(){
        return $this->data['result'];
    }
}