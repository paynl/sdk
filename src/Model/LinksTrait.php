<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Trait LinksTrait
 *
 * @package PayNL\Sdk
 */
trait LinksTrait
{
    /**
     * @var Links
     */
    protected $links;

    /**
     * @return Links
     */
    public function getLinks(): ?Links //FIXME: always return Links object?
    {
        return $this->links;
    }

    /**
     * @param Links $links
     *
     * @return static
     */
    public function setLinks(Links $links): self
    {
        $this->links = $links;
        return $this;
    }
}
