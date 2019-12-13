<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use ReflectionClass, ReflectionException;
use PayNL\Sdk\Hydrator\Simple as SimpleHydrator;

/**
 * Class RequiredMembers
 *
 * @package PayNL\Sdk\Validator
 */
class RequiredMembers extends AbstractValidator
{
    /*
     * Message type constant definitions
     */
    protected const MSG_MISSING_MEMBER = 'MissingMember';
    protected const MSG_EMPTY_MEMBER   = 'EmptyMember';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::MSG_MISSING_MEMBER => 'Required member "%s" is missing',
        self::MSG_EMPTY_MEMBER   => 'Member "%s" is required and therefore cannot be empty',
    ];

    /**
     * @inheritDoc
     */
    public function isValid($filledObjectToCheck): bool
    {
        $required = $this->getRequiredMembers(get_class($filledObjectToCheck));
        if (0 === count($required)) {
            // no required members found, object is valid
            return true;
        }

        $data = (new SimpleHydrator())->extract($filledObjectToCheck);
        foreach ($required as $memberName) {
            if (false === array_key_exists($memberName, $data)) {
                $this->error(static::MSG_MISSING_MEMBER, $memberName);
                continue;
            }

            if (null === $data[$memberName] || '' === $data[$memberName]) {
                $this->error(static::MSG_EMPTY_MEMBER, $memberName);
            }
        }

        return 0 === count($this->getMessages());
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
                && false !== preg_match_all("/@(.*?)\n/s", $docComment, $annotations)
                && true === in_array('required', $annotations[1], true)
            ) {
                $requiredClassMembers[] = $property->getName();
            }
        }

        return $requiredClassMembers;
    }
}
