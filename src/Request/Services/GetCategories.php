<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

/**
 * Class GetCategories
 *
 * @package PayNL\Sdk\Request\Services
 */
class GetCategories extends Get
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "services/{$this->getServiceId()}/categories";
    }
}
