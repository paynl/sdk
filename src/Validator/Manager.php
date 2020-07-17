<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use PayNL\Sdk\Request\ConfigProvider;
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
     * @param $request
     * @return ValidatorInterface
     */
    public function getValidatorByRequest($request) : ValidatorInterface {
        $configProvider = new ConfigProvider();
        $config = $configProvider->getRequestConfig()['services'][$request->getOption('name')];
        if(isset($config['validator'])) {
            return $this->get($config['validator']);
        }

        return $this->get('RequiredMembers');
    }
}
