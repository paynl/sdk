<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\{
    Links as LinksModel,
    Link as LinkModel
};

/**
 * Class Links
 *
 * @package PayNL\Sdk\Hydrator
 */
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

        if (false === array_key_exists('links', $data)) {
            // assume given array are links
            $data = [
                'links' => $data,
            ];
        }

        foreach ($data['links'] as $key => $link) {
            if (true === is_array($link)) {
                $data['links'][$key] = $this->hydratorManager->build('Link')->hydrate($link, $this->modelManager->build('Link'));
            }
        }

        /** @var LinksModel $links */
        $links =  parent::hydrate($data, $object);

        return $links;
    }
}
