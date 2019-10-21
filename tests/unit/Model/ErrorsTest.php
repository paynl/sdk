<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Errors
};
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate;

/**
 * Class ErrorsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ErrorsTest extends UnitTest
{
    /**
     * @var Errors
     */
    protected $errors;

    public function _before(): void
    {
        $this->errors = new Errors();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->errors)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->errors)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetErrors(): void
    {
        verify(method_exists($this->errors, 'setErrors'))->true();
        verify($this->errors->setErrors([]))->isInstanceOf(Errors::class);
    }

    /**
     * @depends testItCanSetErrors
     *
     * @return void
     */
    public function testItCanGetErrors(): void
    {
        verify(method_exists($this->errors, 'getErrors'))->true();

        $this->errors->setErrors([
            'error_1' => 'error_message_1',
            'error_2' => 'error_message_2'
        ]);

        verify($this->errors->getErrors())->array();
        verify($this->errors->getErrors())->count(2);
        verify($this->errors->getErrors())->hasKey('error_1');
        verify($this->errors->getErrors())->hasKey('error_2');
    }

    /**
     * @depends testItCanSetErrors
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->errors)->isInstanceOf(Countable::class);

        $this->errors->setErrors([
            'error_1' => 'error_message_1',
            'error_2' => 'error_message_2'
        ]);

        verify(count($this->errors))->equals(2);
    }

    /**
     * @depends testItCanSetErrors
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->errors)->isInstanceOf(ArrayAccess::class);

        $this->errors->setErrors([
            'error_1' => 'error_message_1',
            'error_2' => 'error_message_2'
        ]);

        // offsetExists
        verify(isset($this->errors['error_1']))->true();
        verify(isset($this->errors['non_existing_key']))->false();

        // offsetGet
        verify($this->errors['error_1'])->equals('error_message_1');

        // offsetSet
        $this->errors['error_3'] = 'error_message_3';
        verify($this->errors)->hasKey('error_3');
        verify($this->errors)->count(3);

        // offsetUnset
        unset($this->errors['error_1']);
        verify($this->errors)->count(2);
        verify($this->errors)->hasntKey('error_1');
    }

    /**
     * @depends testItCanSetErrors
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->errors)->isInstanceOf(IteratorAggregate::class);

        $this->errors->setErrors([
            'error_1' => 'error_message_1',
            'error_2' => 'error_message_2'
        ]);

        verify(is_iterable($this->errors))->true();
    }
}
