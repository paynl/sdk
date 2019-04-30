<?php

namespace Paynl\Result;

/**
 * Base class for the results of the API
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Result
{
    protected $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getRequest()
    {
        return $this->data['request'];
    }

    /**
     * Get the complete result as an array
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
