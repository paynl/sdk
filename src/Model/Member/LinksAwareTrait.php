<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Links;

/**
 * Trait LinksTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait LinksAwareTrait
{
    /**
     * @var Links
     */
    protected $links;

    /**
     * @return Links
     */
    public function getLinks(): Links
    {
        if (null === $this->links) {
            $this->setLinks(new Links());
        }
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
