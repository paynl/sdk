<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Transformer\AbstractTransformer;
use stdClass;

class DummyTransformer extends AbstractTransformer
{
     /** @inheritDoc */
    public function transform($inputToTransform)
    {
        return new stdClass();
    }
}