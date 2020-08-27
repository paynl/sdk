<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Links;

/**
 * Interface LinksAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface LinksAwareInterface
{
    /**
     * @return Links
     */
    public function getLinks(): Links;

    /**
     * @param Links $links
     *
     * @return static
     */
    public function setLinks(Links $links);
}
