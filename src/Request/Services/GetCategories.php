<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\ServiceIdTrait;

/**
 * Class GetCategories
 *
 * @package PayNL\Sdk\Request\Services
 */
class GetCategories extends AbstractRequest
{
    use ServiceIdTrait;

    /**
     * GetCategories constructor.
     *
     * @param string $serviceId
     */
    public function __construct(string $serviceId)
    {
        $this->setServiceId($serviceId);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "services/{$this->getServiceId()}/categories";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }
}
