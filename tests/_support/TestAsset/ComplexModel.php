<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Model\LinksTrait;
use PayNL\Sdk\Model\ModelInterface;
use DateTime;

/**
 * Class SampleModel
 *
 * @package Codeception\TestAsset
 */
class ComplexModel implements ModelInterface
{
    use LinksTrait;

    /**
     * @var string
     */
    protected $foo;

    /**
     * @var SimpleDependencyObject
     */
    protected $bar;

    /**
     * @var DateTime
     */
    protected $baz;

    /**
     * @var SimpleCollection
     */
    protected $corge;

    /**
     * @var ArrayCollection
     */
    protected $arrayCollection;


    /**
     * @return string
     */
    public function getFoo(): string
    {
        return $this->foo;
    }

    /**
     * @param string $foo
     *
     * @return ComplexModel
     */
    public function setFoo(string $foo): self
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
     * @return DateTime
     */
    public function getBaz(): DateTime
    {
        return $this->baz;
    }

    public function getArrayCollection(): ArrayCollection
    {
        return $this->arrayCollection;
    }

    /**
     * @param DateTime $baz
     *
     * @return ComplexModel
     */
    public function setBaz(DateTime $baz): self
    {
        $this->baz = $baz;
        return $this;
    }

    /**
     * @return SimpleCollection
     */
    public function getCorge(): SimpleCollection
    {
        return $this->corge;
    }

    /**
     * @param SimpleCollection $corge
     *
     * @return ComplexModel
     */
    public function setCorge(SimpleCollection $corge): self
    {
        $this->corge = $corge;
        return $this;
    }

    public function setArrayCollection(ArrayCollection $arrayCollection): self
    {
        $this->arrayCollection = $arrayCollection;
        return $this;
    }
}
