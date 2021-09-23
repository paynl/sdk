<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Notification;

/**
 * Interface NotificationAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface NotificationAwareInterface
{
    /**
     * @return Notification
     */
    public function getNotification(): Notification;

    /**
     * @param Notification $notification
     *
     * @return static
     */
    public function setNotification(Notification $notification);
}
