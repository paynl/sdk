<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Parameter;

/**
 * Trait ServiceIdTrait
 *
 * @package PayNL\Sdk\Request\Parameter
 */
trait ServiceIdTrait
{
    /**
     * @var string
     */
    protected $serviceId;

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
     * @return static
     */
    public function setServiceId(string $serviceId): self
    {
        $this->serviceId = $serviceId;
        return $this;
    }
}
