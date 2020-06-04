<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Status;

/**
 * Trait StatusAwareTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait StatusAwareTrait
{
    /**
     * @var Status
     */
    protected $status;

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        if (null === $this->status) {
            $this->setStatus(new Status());
        }
        return $this->status;
    }

    /**
     * @param Status $status
     *
     * @return static
     */
    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }
}
