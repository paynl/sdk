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
class ContactMethods extends AbstractHydrator
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
            if (false === ($contactMethod instanceof ContactMethodModel)) {
                $data['contactMethods'][$key] = (new SimpleHydrator())->hydrate($contactMethod, new ContactMethodModel());
            }
        }

        /** @var ContactMethodsModel $contactMethods */
        $contactMethods = parent::hydrate($data, $object);
        return $contactMethods;
    }
}
