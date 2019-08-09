<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
use Zend\Hydrator\ClassMethods;
use \DateTime;
use PayNL\Sdk\Model\Status as StatusModel;

/**
 * Class Status
 *
 * @package PayNL\Sdk\Hydrator
 */
class Status extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return StatusModel
     */
    public function hydrate(array $data, $object): StatusModel
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, StatusModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

        if (true === array_key_exists('date', $data) && '' !== $data['date']) {
            $data['date'] = DateTime::createFromFormat(DateTime::ATOM, $data['date']);
        }

        if (false === array_key_exists('reason', $data) || true === empty($data['reason'])) {
            $data['reason'] = '';
        }

        /** @var StatusModel $status */
        $status = parent::hydrate($data, $object);
        return $status;
    }
}
