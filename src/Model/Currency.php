<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Currency
 *
 * @package PayNL\Sdk\Model
 */
class Currency implements ModelInterface
{
    /**
     * @var string
     */
    protected $abbreviation;

    /**
     * @var string
     */
    protected $description;

    /**
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     *
     * @return Currency
     */
    public function setAbbreviation(string $abbreviation): Currency
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Currency
     */
    public function setDescription(string $description): Currency
    {
        $this->description = $description;
        return $this;
    }
}
