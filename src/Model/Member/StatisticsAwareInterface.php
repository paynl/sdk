<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Statistics;

/**
 * Interface StatisticsAwareInterface
 *
 * @package PayNL\Sdk\Model\Member
 */
interface StatisticsAwareInterface
{
    /**
     * @return Statistics
     */
    public function getStatistics(): Statistics;

    /**
     * @param Statistics $statistics
     *
     * @return static
     */
    public function setStatistics(Statistics $statistics);
}
