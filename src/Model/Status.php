<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

use DateTime;

/**
 * Class Status
 *
 * @package PayNL\Sdk\Model
 */
class Status implements ModelInterface
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $reason = '';

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Status
     */
    public function setCode(string $code): Status
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Status
     */
    public function setName(string $name): Status
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     *
     * @return Status
     */
    public function setDate(DateTime $date): Status
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     *
     * @return Status
     */
    public function setReason(string $reason): Status
    {
        $this->reason = $reason;
        return $this;
    }
}
