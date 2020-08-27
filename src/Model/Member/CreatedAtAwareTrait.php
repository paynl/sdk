<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Common\DateTime;
use Exception;

/**
 * Trait CreatedAtAwareTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait CreatedAtAwareTrait
{
    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @throws Exception
     *
     * @return DateTime
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getCreatedAt(): DateTime
    {
        if (null === $this->createdAt) {
            $this->setCreatedAt(DateTime::now());
        }
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return static
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
