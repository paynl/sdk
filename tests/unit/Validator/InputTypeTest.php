<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Validator\{
    InputType,
    AbstractValidator,
    ValidatorInterface
};
use stdClass;

/**
 * Class InputTypeTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class InputTypeTest extends UnitTest
{
    /**
     * @var InputType
     */
    protected $validator;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->validator = new InputType();
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
    public function testItMustGetATypeToValidate(): void
    {
        $this->validator->isValid(1);

        $messages = $this->validator->getMessages();
        verify($messages)->count(1);
        verify($messages)->hasKey('NoType');
    }

    /**
     * @return void
     */
    public function testItMustGetAScalarToValidate(): void
    {
        $this->validator->isValid(new stdClass(), 'int');

        $messages = $this->validator->getMessages();
        verify($messages)->count(1);
        verify($messages)->hasKey('ValueIsAnObject');
    }

    /**
     * @return void
     */
    public function testIfGivenValueIsCorrectInstance(): void
    {
        $this->validator->isValid(1, 'string');

        $messages = $this->validator->getMessages();
        verify($messages)->count(1);
        verify($messages)->hasKey('WrongType');
    }
}
