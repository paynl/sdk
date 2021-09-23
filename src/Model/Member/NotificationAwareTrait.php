<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Notification;

/**
 * Trait NotificationAwareTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait NotificationAwareTrait
{
    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        if (null === $this->notification) {
            $this->setNotification(new Notification());
        }

        return $this->notification;
    }

    /**
     * @param Notification $notification
     * @return $this
     */
    public function setNotification(Notification $notification): self
    {
        $this->notification = $notification;
        return $this;
    }
}
