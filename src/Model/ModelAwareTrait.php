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
    /**
     * @var ModelInterface
     */
    protected $model;

    /**
     * @return ModelInterface|null
     */
    public function getModel(): ?ModelInterface
    {
        return $this->model;
    }

    /**
     * @param ModelInterface $model
     *
     * @return static
     */
    public function setModel(ModelInterface $model): self
    {
        $this->model = $model;
        return $this;
    }
}
