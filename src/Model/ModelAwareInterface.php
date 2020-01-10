<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Interface ModelAwareInterface
 *
 * @package PayNL\Sdk\Model
 */
interface ModelAwareInterface
{
    public function getModel(): ?ModelInterface;

    public function setModel(ModelInterface $model);
}
