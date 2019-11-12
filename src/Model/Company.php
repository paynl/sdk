<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;

/**
 * Class Company
 */
class Company implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $coc;

    /**
     * @var string
     */
    protected $vat;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Company
     */
    public function setName(string $name): Company
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCoc(): string
    {
        return $this->coc;
    }

    /**
     * @param string $coc
     *
     * @return Company
     */
    public function setCoc(string $coc): Company
    {
        $this->coc = $coc;
        return $this;
    }

    /**
     * @return string
     */
    public function getVat(): string
    {
        return $this->vat;
    }

    /**
     * @param string $vat
     *
     * @return Company
     */
    public function setVat(string $vat): Company
    {
        $this->vat = $vat;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return Company
     */
    public function setCountryCode(string $countryCode): Company
    {
        $this->countryCode = $countryCode;
        return $this;
    }
}
