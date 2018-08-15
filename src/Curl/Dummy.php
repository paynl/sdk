<?php
namespace Paynl\Curl;

class Dummy implements CurlInterface
{
    /**
     * @var string
     */
    private $_result;

    /**
     * @var mixed
     */
    public $error;

    /**
     * @var string
     */
    public $errorMessage;

    /**
     * @param $result
     */
    public function setResult($result)
    {
        $this->_result = $result;
    }

    /**
     * Prevent possible other uses that might actually do something
     *
     * @param string $name
     * @param mixed $arguments
     * @return bool|mixed
     */
    public function __call($name, $arguments)
    {
        if (in_array($name, array(
            'delete',
            'get',
            'patch',
            'put',
        ), true)) {
            return json_decode($this->_result);
        }
        return true;
    }

    /**
     * This is just a dummy transport, thus return the pre-given results
     *
     * @see Dummy::setResult()
     * @inheritdoc
     */
    public function post($url, array $data = array(), $follow_303_with_post = false)
    {
        return json_decode($this->_result);
    }

    /**
     * This is just a dummy transport, thus ignore
     *
     * @inheritdoc
     */
    public function setOpt($option, $value)
    {
        return true;
    }
}
