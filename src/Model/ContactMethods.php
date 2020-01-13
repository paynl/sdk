<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ContactMethods
 *
 * @package PayNL\Sdk\Model
 */
class ContactMethods extends ArrayCollection implements ModelInterface
{
    /**
     * @return array
     */
    public function getContactMethods(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $contactMethods
     *
     * @return ContactMethods
     */
    public function setContactMethods(array $contactMethods): self
    {
        $this->clear();

        if (0 === count($contactMethods)) {
            return $this;
        }

        foreach ($contactMethods as $contactMethod) {
            $this->addContactMethod($contactMethod);
        }

        return $this;
    }

    /**
     * @param ContactMethod $contactMethod
     *
     * @return ContactMethods
     */
    public function addContactMethod(ContactMethod $contactMethod): self
    {
        // TODO: ask Mike if contact type is unique in the set
        $this->set($contactMethod->getType(), $contactMethod);
        return $this;
    }

    public function getCollectionName(): string
    {
        return 'contactMethods';
    }
}
