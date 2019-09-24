<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\Model\Mandate;
use PayNL\Sdk\Request\Parameter\IncassoOrderIdTrait;
use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Update
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class Update extends AbstractRequest
{
    use IncassoOrderIdTrait;

    public function __construct(string $incassoOrderId, Mandate $mandate)
    {
        $this->setIncassoOrderId($incassoOrderId);
        $this->setBody($mandate);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "directdebits/{$this->getIncassoOrderId()}";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }


}
