<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class State
 *
 * @package PayNL\Sdk\Filter
 */
class State extends AbstractScalar
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'state';
    }
}
