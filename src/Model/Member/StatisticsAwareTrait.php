<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model\Member;

use PayNL\Sdk\Model\Statistics;

/**
 * Trait StatisticsAwareTrait
 *
 * @package PayNL\Sdk\Model\Member
 */
trait StatisticsAwareTrait
{
    /**
     * @var Statistics
     */
    protected $statistics;

    /**
     * @return Statistics
     */
    public function getStatistics(): Statistics
    {
        if (null === $this->statistics) {
            $this->setStatistics(new Statistics());
        }
        return $this->statistics;
    }

    /**
     * @param Statistics $statistics
     *
     * @return static
     */
    public function setStatistics(Statistics $statistics): self
    {
        $this->statistics = $statistics;
        return $this;
    }
}
