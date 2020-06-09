<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Common\DateTime;

/**
 * Interface CreatedAtAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface CreatedAtAwareInterface
{
    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;

    /**
     * @param DateTime $createdAt
     *
     * @return static
     */
    public function setCreatedAt(DateTime $createdAt);
}
