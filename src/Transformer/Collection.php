<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Common\OptionsAwareInterface;
use PayNL\Sdk\Common\OptionsAwareTrait;

/**
 * Class Collection
 *
 * @package PayNL\Sdk\Transformer
 */
class _Collection extends AbstractTransformer implements OptionsAwareInterface
{
    use OptionsAwareTrait;

    protected $model;

    protected $hydrator;

    public function __construct($model, $hydrator)
    {
        $this->model = $model;
        $this->hydrator = $hydrator;
    }

    public function transform($inputToTransform)
    {
        if (false === $this->hasOption('collection_key')) {
            throw new \Exception('Blegh!');
        }

        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return $this->hydrator->hydrate($inputToTransform, $this->model);
    }
}
