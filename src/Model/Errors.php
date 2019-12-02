<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Errors
 *
 * @package PayNL\Sdk\Model
 */
class Errors extends ArrayCollection implements ModelInterface
{
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
    public function setErrors(array $errors): Errors
    {
        $this->clear();
        foreach ($errors as $key => $error) {
            $this->set($key, $error);
        }
        return $this;
    }
}
