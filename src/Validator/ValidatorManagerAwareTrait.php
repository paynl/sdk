<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

/**
 * Trait ValidatorAwareTrait
 *
 * @package PayNL\Sdk\Validator
 */
trait ValidatorManagerAwareTrait
{
    /**
     * @var Manager
     */
    protected $validatorManager;

    /**
     * @return Manager
     */
    public function getValidatorManager(): Manager
    {
        return $this->validatorManager;
    }

    /**
     * @param Manager $validatorManagerManager
     *
     * @return static
     */
    public function setValidatorManager(Manager $validatorManagerManager): self
    {
        $this->validatorManager = $validatorManagerManager;
        return $this;
    }
}
