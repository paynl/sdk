<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Parameter;

/**
 * Class IncassoOrderIdTrait
 *
 * @package PayNL\Sdk\Request\Parameter
 */
trait IncassoOrderIdTrait
{
    /**
     * @var string
     */
    protected $incassoOrderId;

    /**
     * @return string
     */
    public function getIncassoOrderId(): string
    {
        return (string)$this->incassoOrderId;
    }

    /**
     * @param string $incassoOrderId
     *
     * @return static
     */
    public function setIncassoOrderId(string $incassoOrderId): self
    {
        $this->incassoOrderId = $incassoOrderId;
        return $this;
    }
}
