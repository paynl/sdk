<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Validator\{
    ObjectInstance,
    AbstractValidator,
    ValidatorInterface
};
use stdClass, Exception;

/**
 * Class ObjectInstanceTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class ObjectInstanceTest extends UnitTest
{
    /**
     * @var ObjectInstance
     */
    protected $validator;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->validator = new ObjectInstance();
    }

    /**
     * @return void
     */
    public function testItIsAValidator(): void
    {
        verify($this->validator)->isInstanceOf(ValidatorInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->validator)->isInstanceOf(AbstractValidator::class);
    }

    /**
     * @return void
     */
    public function testItMustGetAClassNameToValidate(): void
    {
        $this->validator->isValid(new stdClass());

        $messages = $this->validator->getMessages();
        verify($messages)->count(1);
        verify($messages)->hasKey('NoClassName');
    }

    /**
     * @return void
     */
    public function testItMustGetAnObjectToValidate(): void
    {
        $this->validator->isValid(1, 'Test');

        $messages = $this->validator->getMessages();
        verify($messages)->count(1);
        verify($messages)->hasKey('ValueNotAnObject');
    }

    /**
     * @return void
     */
    public function testIfGivenObjectIsCorrectInstance(): void
    {
        $this->validator->isValid(new stdClass(), Exception::class);

        $messages = $this->validator->getMessages();
        verify($messages)->count(1);
        verify($messages)->hasKey('WrongInstance');
    }
}
