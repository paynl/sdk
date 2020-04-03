<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Traversable;

/**
 * Interface OptionsAwareInterface
 *
 * @package PayNL\Sdk\Common
 */
interface OptionsAwareInterface
{
    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @param array|Traversable $options
     *
     * @return static
     */
    public function setOptions($options);
}
