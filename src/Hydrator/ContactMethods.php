<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\ContactMethod as ContactMethodModel,
    Model\ContactMethods as ContactMethodsModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class ContactMethods
 *
 * @package PayNL\Sdk\Hydrator
 */
class _ContactMethods extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ContactMethodsModel
     */
    public function hydrate(array $data, $object): ContactMethodsModel
    {
        $this->validateGivenObject($object, ContactMethodsModel::class);

        if (false === array_key_exists('contactMethods', $data)) {
            // expect given array is the array of trademarks
            $data = [
                'contactMethods' => $data
            ];
        }

        foreach ($data['contactMethods'] as $key => $contactMethod) {
            $contactMethodModel = $this->modelManager->build('ContactMethod');
            if (false === ($contactMethod instanceof $contactMethodModel)) {
                $data['contactMethods'][$key] = $this->hydratorManager->get('Simple')->hydrate($contactMethod, $contactMethodModel);
            }
        }

        /** @var ContactMethodsModel $contactMethods */
        $contactMethods = parent::hydrate($data, $object);
        return $contactMethods;
    }
}
