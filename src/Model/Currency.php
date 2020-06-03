<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Currency
 *
 * @package PayNL\Sdk\Model
 */
class Currency implements ModelInterface, Member\LinksAwareInterface
{
    use Member\LinksTrait;

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
        return (string)$this->abbreviation;
    }

    /**
     * @param string $abbreviation
     *
     * @return Currency
     */
    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->description;
    }

    /**
     * @param string $description
     *
     * @return Currency
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
