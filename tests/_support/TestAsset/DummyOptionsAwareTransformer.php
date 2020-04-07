<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Common\OptionsAwareInterface;
use PayNL\Sdk\Transformer\AbstractTransformer;
use stdClass;

class DummyOptionsAwareTransformer extends AbstractTransformer implements OptionsAwareInterface
{
    /**
     * @var array
     */
    private $options = [];

     /** @inheritDoc */
    public function transform($inputToTransform)
    {
        return new stdClass();
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function setOptions($options): self
    {
        $this->options = $options;
        return $this;
    }
}