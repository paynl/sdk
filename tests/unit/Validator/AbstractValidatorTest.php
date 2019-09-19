<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Validator\{
    AbstractValidator,
    ValidatorInterface
};
use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class AbstractValidatorTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class AbstractValidatorTest extends UnitTest
{
    /**
     * @var AbstractValidator
     */
    protected $anonymousClassFromAbstract;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class() extends AbstractValidator {
            protected $messageTemplates = [
                'templateKey' => 'Message with variable, %s',
                'keyWithoutVar' => 'Error message',
            ];

            public function isValid($value): bool
            {
                return true;
            }
        };
    }

    /**
     * @return void
     */
    public function testInstanceOfValidatorInterface(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(ValidatorInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractValidator::class);
    }

    /**
     * @return void
     */
    public function testItCanValidate(): void
    {
        verify($this->anonymousClassFromAbstract->isValid(''))->bool();
    }

    /**
     * @return void
     */
    public function testItCanAddAMessage(): void
    {
        expect($this->anonymousClassFromAbstract->addMessage('Test message', 'key'))
            ->isInstanceOf(AbstractValidator::class)
        ;

        expect($this->anonymousClassFromAbstract->addMessage('Test message2', 0))
            ->isInstanceOf(AbstractValidator::class)
        ;

        $this->expectException(InvalidArgumentException::class);
        $this->anonymousClassFromAbstract->addMessage('Test message', 1.0);

        $this->expectException(InvalidArgumentException::class);
        $this->anonymousClassFromAbstract->addMessage('Test message', []);

        $this->expectException(InvalidArgumentException::class);
        $this->anonymousClassFromAbstract->addMessage('Test message', new \stdClass());
    }

    /**
     * @depends testItCanAddAMessage
     *
     * @return void
     */
    public function testItCanSetMessages(): void
    {
        expect($this->anonymousClassFromAbstract->setMessages([
            'Test message',
            'Test message 2',
        ]))->isInstanceOf(AbstractValidator::class);
    }

    /**
     * @depends testItCanAddAMessage
     * @depends testItCanSetMessages
     *
     * @return void
     */
    public function testItCanGetMessages(): void
    {
        verify($this->anonymousClassFromAbstract->getMessages())->array();
        verify($this->anonymousClassFromAbstract->getMessages())->count(0);

        $this->anonymousClassFromAbstract->setMessages([
            'Test message',
            'Test message 2',
        ]);

        verify($this->anonymousClassFromAbstract->getMessages())->count(2);
        verify($this->anonymousClassFromAbstract->getMessages())->contains('Test message');

        $this->anonymousClassFromAbstract->addMessage('Message with key', 'specific key');

        verify($this->anonymousClassFromAbstract->getMessages())->count(3);
        verify($this->anonymousClassFromAbstract->getMessages())->contains('Message with key');
        verify($this->anonymousClassFromAbstract->getMessages())->hasKey('specific key');
    }

    /**
     * @depends testItCanAddAMessage
     * @depends testItCanGetMessages
     *
     * @return void
     */
    public function testItCanAddAnError(): void
    {
        verify($this->anonymousClassFromAbstract->error('templateKey', 'VariableValue'))->null();

        $this->anonymousClassFromAbstract->error('keyWithoutVar');
        $this->anonymousClassFromAbstract->error('templateKey', 'VariableValue');

        $messages = $this->anonymousClassFromAbstract->getMessages();
        verify($messages)->count(2);
        verify($messages)->contains('Error message');
        verify($messages)->contains('Message with variable, VariableValue');

        $this->expectException(InvalidArgumentException::class);
        $this->anonymousClassFromAbstract->error('NonExistingKey', 'VariableValue');
    }
}
