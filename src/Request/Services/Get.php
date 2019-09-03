<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Services
 */
class Get extends AbstractRequest
{
    /**
     * @var string
     */
    protected $serviceId;

    /**
     * Get constructor.
     *
     * @param string $serviceId
     */
    public function __construct(string $serviceId)
    {
        $this->setServiceId($serviceId);
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    /**
     * @param string $serviceId
     *
     * @return Get
     */
    public function setServiceId(string $serviceId): Get
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'services/' . $this->getServiceId();
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

}
