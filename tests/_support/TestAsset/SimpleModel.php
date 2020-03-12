<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Model\ModelInterface;

/**
 * Class SimpleModel
 *
 * @package Codeception\TestAsset
 */
class SimpleModel implements ModelInterface
{
    /**
     * @var string
     */
    protected $corge = '';

    /**
     * @return string
     */
    public function getCorge(): string
    {
        return $this->corge;
    }

    /**
     * @param string $corge
     *
     * @return SimpleModel
     */
    public function setCorge(string $corge): self 
    {
        $this->corge = $corge;
        return $this;
    }
}
