<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Trait ModelAwareTrait
 *
 * @package PayNL\Sdk\Model
 */
trait ModelAwareTrait
{
    protected $model;

    public function getModel(): ?ModelInterface
    {
        return $this->model;
    }

    public function setModel(ModelInterface $model)
    {
        $this->model = $model;
        return $this;
    }
}
