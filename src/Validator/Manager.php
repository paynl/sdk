<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use PayNL\Sdk\Exception\RuntimeException;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Validator
 */
class Manager extends AbstractPluginManager
{
    /**
     * @var string
     *
     * @see AbstractPluginManager::$instanceOf
     */
    protected $instanceOf = ValidatorInterface::class;

    /**
     * Returns the validator specified in the config if found. if not return the default RequiredMembers validator
     *
     * @param AbstractRequest $request
     * @return ValidatorInterface
     */
    public function getValidatorByRequest(AbstractRequest $request): ValidatorInterface
    {
        $options = $request->getOptions();
        if (true === isset($options['validator'])) {
            if(true === is_string($options['validator']) && true === $this->has($options['validator'])) {
                return $this->get($options['validator']);
            }
            if (false === is_callable($options['validator'])) {
                throw new RuntimeException('Config validator is not a valid validation class.');
            }
            return ($options['validator'])();
        }

        return $this->get('RequiredMembers');
    }
}
