<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\RuntimeException;
use ReflectionClass, ReflectionException;
use Zend\Hydrator\HydratorAwareInterface;
use Zend\Hydrator\HydratorAwareTrait;

/**
 * Class RequiredMembers
 *
 * @package PayNL\Sdk\Validator
 */
class RequiredMembers extends AbstractValidator implements HydratorAwareInterface
{
    use HydratorAwareTrait;

    /*
     * Message type constant definitions
     */
    public const MSG_MISSING_MEMBER  = 'MissingMember';
    public const MSG_MISSING_MEMBERS = 'MissingMembers';
    public const MSG_EMPTY_MEMBER    = 'EmptyMember';
    public const MSG_EMPTY_MEMBERS   = 'EmptyMembers';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::MSG_MISSING_MEMBER  => 'Required member "%s" is missing in %s',
        self::MSG_MISSING_MEMBERS => 'Required members "%s" are missing in %s',
        self::MSG_EMPTY_MEMBER    => 'Member "%s" within %s is required and therefore cannot be empty',
        self::MSG_EMPTY_MEMBERS   => 'Members "%s" within %s are required and therefore cannot be empty',
    ];

    protected $className;

    /**
     * @inheritDoc
     */
    public function isValid($filledObjectToCheck): bool
    {
        $this->className = get_class($filledObjectToCheck);
        $required = $this->getRequiredMembers($this->className);
        if (0 === count($required)) {
            // no required members found, object is valid
            return true;
        }

        return $this->validate($required, $this->getDataFromObject($filledObjectToCheck));
    }

    /**
     * @param array $required
     * @param array $data
     * @return bool
     */
    protected function validate(array $required, array $data): bool {
        $missingMembers = $emptyMembers = [];

        foreach (array_keys($required) as $memberName) {
            if (false === array_key_exists($memberName, $data)) {
                $missingMembers[] = $memberName;
            } elseif (true === $this->isEmpty($memberName, $data[$memberName])) {
                $emptyMembers[] = $memberName;
            }
        }

        $nrOfMissingMembers = count($missingMembers);
        if (0 < $nrOfMissingMembers) {
            $this->error(
                1 === $nrOfMissingMembers ? static::MSG_MISSING_MEMBER : static::MSG_MISSING_MEMBERS,
                implode('", "', $missingMembers),
                $this->className
            );
        }

        $nrOfEmptyMembers = count($emptyMembers);
        if (0 < $nrOfEmptyMembers) {
            $this->error(
                1 === $nrOfEmptyMembers ? static::MSG_EMPTY_MEMBER : static::MSG_EMPTY_MEMBERS,
                implode('", "', $emptyMembers),
                $this->className
            );
        }

        return 0 === $nrOfMissingMembers + $nrOfEmptyMembers;
    }

    /**
     * @param string $className
     *
     * @return array
     */
    protected function getRequiredMembers(string $className): array
    {
        $ref = null;
        try {
            $ref = new ReflectionClass($className);
        } catch (ReflectionException $re) {
            // does nothing because non-existing class names
            // can't be entered
            return [];
        }

        $requiredClassMembers = [];

        foreach ($ref->getProperties() as $property) {
            $docComment = $property->getDocComment();
            if (false !== $docComment
                && false !== preg_match_all("/@(?P<tag>\S+)(?:\n|\s(?P<type>.+)\n)/s", $docComment, $annotations)
                && true === in_array('required', $annotations['tag'], true)
            ) {
                $requiredClassMembers[$property->getName()] = $annotations['type'][array_search('var', $annotations['tag'], true)] ?? '';
            }
        }

        return $requiredClassMembers;
    }

    /**
     * @param mixed $objectToExtract
     *
     * @throws RuntimeException when the hydrator can not be found
     * @throws InvalidArgumentException when given object isn't an object
     *
     * @return array
     */
    protected function getDataFromObject($objectToExtract): array
    {
        $hydrator = $this->getHydrator();
        if (null === $hydrator) {
            throw new RuntimeException(
                sprintf(
                    'Hydrator for "%s" is not set',
                    __CLASS__
                )
            );
        }

        if (false === is_object($objectToExtract)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given argument to "%s" must be an object, %s given',
                    __METHOD__,
                    gettype($objectToExtract)
                )
            );
        }

        return $hydrator->extract($objectToExtract);
    }

    /**
     * Checks if the given $value is empty. In other words, its an empty string, null or
     * (if the key is an id field) equal to zero (0).
     *
     * @param string|int $key
     * @param mixed $value
     *
     * @return bool
     */
    private function isEmpty($key, $value): bool
    {
        return null === $value
            || '' === $value
            || (
                1 === preg_match('/^(id$|(.*)Id)$/', (string)$key)
                && 0 === $value
            )
        ;
    }
}
