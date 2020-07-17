<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator\Qr;

use PayNL\Sdk\Validator\RequiredMembers;

/**
 * Class RequiredMembers
 *
 * @package PayNL\Sdk\Validator
 */
class Encode extends RequiredMembers
{
    public function isValid($filledObjectToCheck): bool
    {
        $requiredMembers = array('secret');
        $this->className = get_class($filledObjectToCheck);
        $data = $this->getDataFromObject($filledObjectToCheck);

        return $this->validate(array_flip($requiredMembers), $data);
    }
}