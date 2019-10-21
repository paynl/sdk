<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\{
    Links as LinksModel,
    Link as LinkModel
};

class Links extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return LinksModel
     */
    public function hydrate(array $data, $object): LinksModel
    {
        $this->validateGivenObject($object, LinksModel::class);

        foreach ($data as $key => $link) {
            if (false === ($link instanceof LinkModel)) {
                $data[$key] = (new Link())->hydrate($link, new LinkModel());
            }
        }

        /** @var LinksModel $links */
        $links =  parent::hydrate(['links' => $data], $object);

        return $links;
    }
}
