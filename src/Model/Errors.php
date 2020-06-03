<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Common\CollectionInterface;

/**
 * Class Errors
 *
 * @package PayNL\Sdk\Model
 */
class Errors extends ArrayCollection implements ModelInterface, CollectionInterface, Member\LinksAwareInterface
{
    use Member\LinksTrait;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $errors
     *
     * @return Errors
     */
    public function setErrors(array $errors): self
    {
        $this->clear();
        foreach ($errors as $key => $error) {
            $this->set($key, $error);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCollectionName(): string
    {
        return 'errors';
    }
}
