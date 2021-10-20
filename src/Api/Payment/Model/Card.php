<?php

namespace Paynl\Api\Payment\Model;

class Card extends Model
{
    /**
     * @var string
     */
    private $expire_month;

    /**
     * @var string
     */
    private $expire_year;

    /**
     * @var string
     */
    private $cvc;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $number;

    /**
     * @return string
     */
    public function getExpireMonth()
    {
        return $this->expire_month;
    }

    /**
     * @param string $expire_month
     * @return static
     */
    public function setExpireMonth($expire_month)
    {
        $this->expire_month = $expire_month;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpireYear()
    {
        return $this->expire_year;
    }

    /**
     * @param string $expire_year
     * @return static
     */
    public function setExpireYear($expire_year)
    {
        $this->expire_year = $expire_year;
        return $this;
    }

    /**
     * @return string
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @param string $cvc
     * @return static
     */
    public function setCvc($cvc)
    {
        $this->cvc = $cvc;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return static
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return static
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
}