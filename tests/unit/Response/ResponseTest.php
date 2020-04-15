<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Response;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\Error;
use PayNL\Sdk\Response\Response;
use PayNL\Sdk\Model\Errors;
use PayNL\Sdk\Response\ResponseInterface;
use UnitTester;

/**
 * Class ResponseTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class ResponseTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->response = new Response();
    }

    /**
     * @return void
     */
    public function testItCanSetFormat(): void
    {
        $this->tester->assertObjectHasMethod('setFormat', $this->response);
        $this->tester->assertObjectMethodIsPublic('setFormat', $this->response);

        $response = $this->response->setFormat('foo');
        verify($response)->object();
        verify($response)->same($this->response);
    }

    /**
     * @depends testItCanSetFormat
     *
     * @return void
     */
    public function testItCanGetFormat(): void
    {
        $this->tester->assertObjectHasMethod('getFormat', $this->response);
        $this->tester->assertObjectMethodIsPublic('getFormat', $this->response);

        $format = $this->response->getFormat();
        verify($format)->string();
        verify($format)->equals(ResponseInterface::FORMAT_OBJECTS);

        $this->response->setFormat('foo');
        $format = $this->response->getFormat();
        verify($format)->string();
        verify($format)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetStatusCode(): void
    {
        $this->tester->assertObjectHasMethod('setStatusCode', $this->response);
        $this->tester->assertObjectMethodIsPublic('setStatusCode', $this->response);

        $response = $this->response->setStatusCode(503);
        verify($response)->object();
        verify($response)->same($this->response);
    }

    /**
     * @depends testItCanSetStatusCode
     *
     * @return void
     */
    public function testSetStatusCodeThrowsExceptionForInvalidCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->response->setStatusCode(600);
    }

    /**
     * @depends testItCanSetStatusCode
     *
     * @return void
     */
    public function testItCanGetStatusCode(): void
    {
        $this->tester->assertObjectHasMethod('getStatusCode', $this->response);
        $this->tester->assertObjectMethodIsPublic('getStatusCode', $this->response);

        $this->response->setStatusCode(503);
        $statusCode = $this->response->getStatusCode();
        verify($statusCode)->int();
        verify($statusCode)->equals(503);
    }

    /**
     * @return void
     */
    public function testItCanSetRawBody(): void
    {
        $this->tester->assertObjectHasMethod('setRawBody', $this->response);
        $this->tester->assertObjectMethodIsPublic('setRawBody', $this->response);

        $response = $this->response->setRawBody('foo bar');
        verify($response)->object();
        verify($response)->same($this->response);
    }

    /**
     * @depends testItCanSetRawBody
     *
     * @return void
     */
    public function testItCanGetRawBody(): void
    {
        $this->tester->assertObjectHasMethod('getRawBody', $this->response);
        $this->tester->assertObjectMethodIsPublic('getRawBody', $this->response);

        $this->response->setRawBody('foo bar');
        $rawBody = $this->response->getRawBody();
        verify($rawBody)->string();
        verify($rawBody)->equals('foo bar');
    }

    /**
     * @return void
     */
    public function testItCanSetBody(): void
    {
        $this->tester->assertObjectHasMethod('setBody', $this->response);
        $this->tester->assertObjectMethodIsPublic('setBody', $this->response);

        $response = $this->response->setBody('foo bar');
        verify($response)->object();
        verify($response)->same($this->response);
    }

    /**
     * @depends testItCanSetBody
     * @depends testItCanSetStatusCode
     *
     * @return void
     */
    public function testItCanSetBodyBasedOnHttpStatusCode(): void
    {
        $response = $this->response->setStatusCode(400);
        $body = $response->getBody();

        verify($body)->string();
        verify($body)->notEmpty();
        verify($body)->equals('Bad Request');
    }

    /**
     * @depends testItCanSetBody
     *
     * @return void
     */
    public function testItCanGetBody(): void
    {
        $this->tester->assertObjectHasMethod('getBody', $this->response);
        $this->tester->assertObjectMethodIsPublic('getBody', $this->response);

        $this->response->setBody('foo bar');
        $body = $this->response->getBody();
        verify($body)->string();
        verify($body)->equals('foo bar');
    }

    /**
     * @depends testItCanGetStatusCode
     * @depends testItCanGetBody
     * @depends testItCanSetStatusCode
     * @depends testItCanSetBody
     *
     * @return void
     */
    public function testItHasErrors(): void
    {
        $this->tester->assertObjectHasMethod('hasErrors', $this->response);
        $this->tester->assertObjectMethodIsPublic('hasErrors', $this->response);

        $hasErrors = $this->response->hasErrors();
        verify($hasErrors)->bool();
        verify($hasErrors)->false();

        $this->response->setStatusCode(400)
            ->setBody('')
        ;
        $hasErrors = $this->response->hasErrors();
        verify($hasErrors)->bool();
        verify($hasErrors)->true();

        $mockErrors = $this->tester->grabMockService('modelManager')->get(Errors::class);
        $this->response->setStatusCode(200)
            ->setBody($mockErrors)
        ;
        $hasErrors = $this->response->hasErrors();
        verify($hasErrors)->bool();
        verify($hasErrors)->true();
    }

    /**
     * @depends testItHasErrors
     * @depends testItCanGetBody
     * @depends testItCanSetBody
     *
     * @return void
     */
    public function testItCanGetErrors(): void
    {
        /** @var Errors $mockErrors */
        $mockErrors = $this->tester->grabService('modelManager')->get(Errors::class);
        /** @var Error $mockError */
        $mockError = $this->tester->grabService('modelManager')->get(Error::class);
        $mockError->setCode(400)
            ->setMessage('foo bar')
        ;
        $mockErrors->setErrors([$mockError]);

        $this->response->setBody($mockErrors);

        $errors = $this->response->getErrors();
        verify($errors)->string();
        verify($errors)->notEmpty();
    }

    /**
     * @depends testItCanGetErrors
     *
     * @return void
     */
    public function testGetErrorsReturnBodyWhenNoErrorsModel(): void
    {
        $this->response->setStatusCode(400);

        $errors = $this->response->getErrors();
        verify($errors)->string();
        verify($errors)->equals('Bad Request');
    }

    /**
     * @depends testItCanGetErrors
     *
     * @return void
     */
    public function testGetErrorsIsEmptyWhenItHasNoErrors(): void
    {
        $this->response->setBody('foo bar');

        $errors = $this->response->getErrors();
        verify($errors)->string();
        verify($errors)->equals('');
    }
}
