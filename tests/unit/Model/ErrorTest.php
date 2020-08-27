<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Error;

/**
 * Class ErrorTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ErrorTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Error
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Error();
    }

    public function testItCanSetContext(): void
    {
        $this->tester->assertObjectHasMethod('setContext', $this->model);
        $this->tester->assertObjectMethodIsPublic('setContext', $this->model);

        $error = $this->model->setContext('foo');
        verify($error)->object();
        verify($error)->same($this->model);
    }

    /**
     * @depends testItCanSetContext
     *
     * @return void
     */
    public function testItCanGetContext(): void
    {
        $this->tester->assertObjectHasMethod('getContext', $this->model);
        $this->tester->assertObjectMethodIsPublic('getContext', $this->model);

        $context = $this->model->getContext();
        verify($context)->string();
        verify($context)->isEmpty();

        $this->model->setContext('foo');
        $context = $this->model->getContext();
        verify($context)->string();
        verify($context)->notEmpty();
        verify($context)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetCode(): void
    {
        $this->tester->assertObjectHasMethod('setCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCode', $this->model);

        $error = $this->model->setCode(100);
        verify($error)->object();
        verify($error)->same($this->model);
    }

    /**
     * @depends testItCanSetCode
     *
     * @return void
     */
    public function testItCanGetCode(): void
    {
        $this->tester->assertObjectHasMethod('getCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCode', $this->model);

        $code = $this->model->getCode();
        verify($code)->int();
        verify($code)->equals(0);

        $this->model->setCode(100);
        $code = $this->model->getCode();
        verify($code)->int();
        verify($code)->equals(100);
    }

    /**
     * @return void
     */
    public function testItCanSetMessage(): void
    {
        $this->tester->assertObjectHasMethod('setMessage', $this->model);
        $this->tester->assertObjectMethodIsPublic('setMessage', $this->model);

        $error = $this->model->setMessage('foo bar baz');
        verify($error)->object();
        verify($error)->same($this->model);
    }

    /**
     * @depends testItCanSetMessage
     *
     * @return void
     */
    public function testItCanGetMessage(): void
    {
        $this->tester->assertObjectHasMethod('getMessage', $this->model);
        $this->tester->assertObjectMethodIsPublic('getMessage', $this->model);

        $message = $this->model->getMessage();
        verify($message)->string();
        verify($message)->isEmpty();

        $this->model->setMessage('foo bar baz');
        $message = $this->model->getMessage();
        verify($message)->string();
        verify($message)->notEmpty();
        verify($message)->equals('foo bar baz');
    }

    /**
     * @depends testItCanGetCode
     * @depends testItCanGetMessage
     * @depends testItCanSetCode
     * @depends testItCanSetMessage
     *
     * @return void
     */
    public function testItCanConvertToString(): void
    {
        $this->tester->assertObjectHasMethod('__toString', $this->model);
        $this->tester->assertObjectMethodIsPublic('__toString', $this->model);

        $this->model->setCode(100)
            ->setMessage('foo bar baz')
        ;

        $error = (string)$this->model;
        verify($error)->string();
        verify($error)->notEmpty();
        verify($error)->equals('Error (100): foo bar baz');
    }
}
