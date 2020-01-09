<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

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
     * @param array $options
     *
     * @return static
     */
    public function setOptions(array $options);
}
