<?php

namespace Paynl\Api\Payment\Model;

class CSE extends Model
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $data;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return static
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}