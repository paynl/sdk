<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Parameter;

/**
 * Trait MerchantIdTrait
 *
 * @package PayNL\Sdk\Request\Parameter
 */
trait MerchantIdTrait
{
    /**
     * @var string
     */
    protected $merchantId;

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     *
     * @return static
     */
    public function setMerchantId(string $merchantId): self
    {
        $this->merchantId = $merchantId;
        return $this;
    }
}
