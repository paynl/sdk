<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Model\LinksTrait;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class SampleModel
 *
 * @package Codeception\TestAsset
 */
class ComplexModel implements ModelInterface
{
    use LinksTrait;

    /**
     * @var InvokableObject
     */
    protected $foo;

    /**
     * @var SimpleDependencyObject
     */
    protected $bar;

    /**
     * @var SimpleDateTime
     */
    protected $baz;

    /**
     * @return InvokableObject
     */
    public function getFoo(): InvokableObject
    {
        return $this->foo;
    }

    /**
     * @param InvokableObject $foo
     *
     * @return ComplexModel
     */
    public function setFoo(InvokableObject $foo): self
    {
        $this->foo = $foo;
        return $this;
    }

    /**
     * @return SimpleDependencyObject
     */
    public function getBar(): SimpleDependencyObject
    {
        return $this->bar;
    }

    /**
     * @param SimpleDependencyObject $bar
     *
     * @return ComplexModel
     */
    public function setBar(SimpleDependencyObject $bar): self
    {
        $this->bar = $bar;
        return $this;
    }

    /**
     * @return SimpleDateTime
     */
    public function getBaz(): SimpleDateTime
    {
        return $this->baz;
    }

    /**
     * @param SimpleDateTime $baz
     *
     * @return ComplexModel
     */
    public function setBaz(SimpleDateTime $baz): self
    {
        $this->baz = $baz;
        return $this;
    }
}
