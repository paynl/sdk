<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Common\TotalCollection;

/**
 * Class Services
 *
 * @package PayNL\Sdk\Model
 */
class Services extends TotalCollection implements ModelInterface
{
    use LinksTrait;

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $services
     *
     * @return Services
     */
    public function setServices(array $services): self
    {
        // reset the total
        $this->clear();

        if (0 === count($services)) {
            return $this;
        }

        foreach ($services as $service) {
            $this->addService($service);
        }

        return $this;
    }

    /**
     * @param Service $service
     *
     * @return Services
     */
    public function addService(Service $service): self
    {
        $this->set($service->getId(), $service);
        return $this;
    }

    public function getCollectionName(): string
    {
        return 'services';
    }
}
