<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Dummy
 *
 * @package Codeception\TestAsset
 */
class DummyJsonSerializable implements JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $foo = 'bar';

    /**
     * @var string
     */
    protected $baz = 'qux';

    /**
     * @var array
     */
    protected $quux = [];

    /**
     * @var DummyArrayCollection
     */
    protected $collection;

    /**
     * DummyJsonSerializable constructor.
     */
    public function __construct()
    {
        $this->collection = new DummyArrayCollection();
    }

}
