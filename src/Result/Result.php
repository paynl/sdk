<?php
/*
 * Copyright (C) 2015 Pay.nl
 */

namespace Paynl\Result;

/**
 * Description of Result
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Result
{
    protected $data = array();
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }
}