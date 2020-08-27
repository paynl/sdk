<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Status;

/**
 * Interface StatusAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface StatusAwareInterface
{
    /**
     * @return Status
     */
    public function getStatus(): Status;

    /**
     * @param Status $status
     *
     * @return static
     */
    public function setStatus(Status $status);
}
