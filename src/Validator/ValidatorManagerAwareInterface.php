<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

/**
 * Interface ValidatorAwareInterface
 *
 * @package PayNL\Sdk\Validator
 */
interface ValidatorManagerAwareInterface
{
    /**
     * @return Manager
     */
    public function getValidatorManager(): Manager;

    /**
     * @param Manager $validatorManager
     *
     * @return ValidatorManagerAwareInterface
     */
    public function setValidatorManager(Manager $validatorManager);
}
