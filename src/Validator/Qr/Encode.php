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
    /**
     * @inheritDoc
     */
    protected function getRequiredMembers(string $className): array
    {
        return [
            'secret' => true,
        ];
    }
}