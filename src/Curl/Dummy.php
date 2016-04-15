<?php
namespace Paynl\Curl;

class Dummy
{
    private $_result;

    public $error;

    /**
     * Set the result, this will be returned when post
     *
     * @param $result
     */
    public function __construct($result)
    {
        $this->_result = $result;
    }


    //dummy function to prevent errors
    public function __call($name, $arguments)
    {
        if(in_array($name, array(
            'delete',
            'get',
            'patch',
            'post',
            'put',
        ))){
            return json_decode($this->_result);
        }
        return true;
    }
}