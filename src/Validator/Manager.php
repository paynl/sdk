<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Validator
 */
class Manager extends AbstractPluginManager
{
    protected $instanceOf = ValidatorInterface::class;
}
