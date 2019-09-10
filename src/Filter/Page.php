<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class Page
 *
 * @package PayNL\Sdk\Filter
 */
class Page extends AbstractScalar
{
    public function getName(): string
    {
        return 'page';
    }
}
