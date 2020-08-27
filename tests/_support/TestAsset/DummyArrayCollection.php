<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Dummy
 *
 * @package Codeception\TestAsset
 */
class DummyArrayCollection extends ArrayCollection implements JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'foo' => 'bar'
        ];
    }
}

