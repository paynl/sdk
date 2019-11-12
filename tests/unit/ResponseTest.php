<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Response;

/**
 * Class ResponseTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class ResponseTest extends UnitTest
{
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
    public function testItCanSetAStatusCode(): void
    {
        expect($this->response->setStatusCode(503))->isInstanceOf(Response::class);

        $this->expectException(InvalidArgumentException::class);
        $this->response->setStatusCode(600);
    }

    /**
     * @depends testItCanSetAStatusCode
     *
     * @return void
     */
    public function testItCanGetAStatusCode(): void
    {
        $this->response->setStatusCode(503);
        verify($this->response->getStatusCode())->int();
        verify($this->response->getStatusCode())->equals(503);
    }

    /**
     * @return void
     */
    public function testItCanSetARawBody(): void
    {
        expect($this->response->setRawBody('RAW: ' . Response::HTTP_STATUS_CODES[503]))->isInstanceOf(Response::class);
    }

    /**
     * @depends testItCanSetARawBody
     *
     * @return void
     */
    public function testItCanGetARawBody(): void
    {
        $this->response->setRawBody('RAW: ' . Response::HTTP_STATUS_CODES[503]);
        verify($this->response->getRawBody())->string();
        verify($this->response->getRawBody())->equals('RAW: Service Unavailable');
    }

    /**
     * @return void
     */
    public function testItCanSetABody(): void
    {
        expect($this->response->setBody(Response::HTTP_STATUS_CODES[503]))->isInstanceOf(Response::class);
    }

    /**
     * @depends testItCanSetABody
     *
     * @return void
     */
    public function testItCanSetBodyBasedOnHttpStatusCode(): void
    {
        $this->response->setStatusCode(400);

        verify($this->response->getBody())->string();
        verify($this->response->getBody())->notEmpty();
    }

    /**
     * @depends testItCanSetABody
     *
     * @return void
     */
    public function testItCanGetABody(): void
    {
        $this->response->setBody(Response::HTTP_STATUS_CODES[503]);
        verify($this->response->getBody())->string();
        verify($this->response->getBody())->equals('Service Unavailable');
    }
}
