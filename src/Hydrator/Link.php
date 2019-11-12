<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\Link as LinkModel;

/**
 * Class Link
 *
 * @package PayNL\Sdk\Hydrator
 */
class Link extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return LinkModel
     */
    public function hydrate(array $data, $object): LinkModel
    {
        $this->validateGivenObject($object, LinkModel::class);

        /** @var LinkModel $link */
        $link = parent::hydrate($data, $object);
        return $link;
    }
}
