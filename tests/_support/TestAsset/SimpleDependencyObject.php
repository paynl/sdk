<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Model\ModelInterface;

/**
 * Class SimpleDependencyObject
 *
 * @package Codeception\TestAsset
 */
class SimpleDependencyObject implements ModelInterface
{
    /**
     * @var string
     */
    protected $qux;

    /**
     * @return string
     */
    public function getQux(): string
    {
        return $this->qux;
    }

    /**
     * @param string $qux
     *
     * @return SimpleDependencyObject
     */
    public function setQux(string $qux): self
    {
        $this->qux = $qux;
        return $this;
    }
}
