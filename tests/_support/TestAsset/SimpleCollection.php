<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Common\CollectionInterface;

/**
 * Class SimpleCollection
 *
 * @package Codeception\TestAsset
 */
class SimpleCollection extends ArrayCollection implements CollectionInterface
{
    /**
     * @return array
     */
    public function getSimpleModels(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $simpleModels
     *
     * @return SimpleCollection
     */
    public function setSimpleModels(array $simpleModels): self
    {
        $this->clear();

        if (0 === count($simpleModels)) {
            return $this;
        }

        foreach ($simpleModels as $simpleModel) {
            $this->addSimpleModel($simpleModel);
        }

        return $this;
    }

    /**
     * @param SimpleModel $simpleModel
     *
     * @return SimpleCollection
     */
    public function addSimpleModel(SimpleModel $simpleModel): self
    {
        $this->add($simpleModel);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCollectionName(): string
    {
        return 'simpleModels';
    }
}
