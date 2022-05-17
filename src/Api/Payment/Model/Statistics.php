<?php

namespace Paynl\Api\Payment\Model;

class Statistics extends Model
{
    /**
     * @var string
     */
    private $object;

    /**
     * @var string
     */
    private $extra1;

    /**
     * @var string
     */
    private $extra2;
    
    /**
     * @var string
     */
    private $extra3;

    /**
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param $object
     * @return $this
     */
    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra1()
    {
        return $this->extra1;
    }

    /**
     * @param $extra1
     * @return $this
     */
    public function setExtra1($extra1)
    {
        $this->extra1 = $extra1;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra2()
    {
        return $this->extra2;
    }

    /**
     * @param $extra2
     * @return $this
     */
    public function setExtra2($extra2)
    {
        $this->extra2 = $extra2;
        return $this;
    }


    /**
     * @return string
     */
    public function getExtra3()
    {
        return $this->extra3;
    }

    /**
     * @param $extra3
     * @return $this
     */
    public function setExtra3($extra3)
    {
        $this->extra3 = $extra3;
        return $this;
    }

}