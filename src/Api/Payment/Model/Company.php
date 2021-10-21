<?php

namespace Paynl\Api\Payment\Model;

class Company extends Model
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $cocNumber;

    /**
     * @var string
     */
    private $vatNumber;

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
    public function getCocNumber()
    {
        return $this->cocNumber;
    }

    /**
     * @param string $cocNumber
     * @return static
     */
    public function setCocNumber($cocNumber)
    {
        $this->cocNumber = $cocNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     * @return static
     */
    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;
        return $this;
    }
}