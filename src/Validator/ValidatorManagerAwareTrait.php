<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use PayNL\Sdk\Exception\RuntimeException;

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
     * @throws RuntimeException
     *
     * @return Manager
     */
    public function getValidatorManager(): Manager
    {
        if ($this->validatorManager === null) {
            throw new RuntimeException('ValidatorManager was not set');
        }
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
