<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

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

    /**
     * @inheritDoc
     */
    public function isValid($filledObjectToCheck): bool
    {
        $className = get_class($filledObjectToCheck);
        $required = $this->getRequiredMembers($className);
        if (0 === count($required)) {
            // no required members found, object is valid
            return true;
        }

        $hydrator = $this->getHydrator();
        if (null === $hydrator) {
            throw new \Exception('No hydrator');
        }

        $data = $hydrator->extract($filledObjectToCheck);
        $missingMembers = $emptyMembers = [];
        foreach ($required as $memberName => $type) {
            if (false === array_key_exists($memberName, $data)) {
                $missingMembers[] = $memberName;
                continue;
            }

            // filter zero only if its an id field
            if (null === $data[$memberName]
                || '' === $data[$memberName]
                || (
                    true === is_int($data[$memberName])
                    && 1 === preg_match('/^(?P<idKey>id$|(.*)Id)$/', (string)$memberName, $match)
                    && 0 === $data[$memberName]
                )
            ) {
                $emptyMembers[] = $memberName;
            }
        }

        $nrOfMissingMembers = count($missingMembers);
        if (0 < $nrOfMissingMembers) {
            $this->error(1 === $nrOfMissingMembers ? static::MSG_MISSING_MEMBER : static::MSG_MISSING_MEMBERS, implode('", "', $missingMembers), $className);
        }

        $nrOfEmptyMembers = count($emptyMembers);
        if (0 < $nrOfEmptyMembers) {
            $this->error(1 === $nrOfEmptyMembers ? static::MSG_EMPTY_MEMBER : static::MSG_EMPTY_MEMBERS, implode('", "', $emptyMembers), $className);
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
        }

        $requiredClassMembers = [];

        if (null === $ref) {
            return $requiredClassMembers;
        }

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
}
