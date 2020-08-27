<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Api;

use Codeception\Test\Unit as UnitTest;
use PayNL\GuzzleHttp\{
    Client,
    HandlerStack
};
use PayNL\Sdk\{Api\Api,
    AuthAdapter\AdapterInterface,
    AuthAdapter\Basic,
    Request\Request,
    Request\RequestInterface,
    Response\Response,
    Response\ResponseInterface};
use UnitTester, Exception;

/**
 * Class ApiTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class ApiTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Api
     */
    protected $api;

    /**
     * @throws Exception
     *
     * @return void
     */
    public function _before(): void
    {
        $adapterMock = $this->tester->grabMockService('authAdapterManager')->get('Basic');

        /** @var Client $clientMock */
        $clientMock = $this->make(Client::class, [
            'config' => [
                'base_uri' => 'https://rest-api.idefix.mike.dev.pay.nl',
                'handler'  => HandlerStack::create(),
            ]
        ]);

        $this->api = new Api($adapterMock, $clientMock);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetGuzzleClient(): void
    {
        /** @var Client $clientMock */
        $clientMock = $this->make(Client::class);

        verify($this->tester->invokeMethod($this->api, 'setClient', [$clientMock]))->isInstanceOf(Api::class);
    }

    /**
     * @return void
     */
    public function testItCanGetGuzzleClient(): void
    {
        verify(method_exists($this->api, 'getClient'))->true();
        verify($this->api->getClient())->isInstanceOf(Client::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAuthAdapter(): void
    {
        /** @var AdapterInterface $adapterMock */
        $adapterMock = $this->tester->grabMockService('authAdapterManager')->get('Basic');

        verify($this->tester->invokeMethod($this->api, 'setAuthAdapter', [$adapterMock]))->isInstanceOf(Api::class);
    }

    public function testItCanGetAuthAdapter(): void
    {
        verify(method_exists($this->api, 'getAuthAdapter'))->true();
        verify($this->api->getAuthAdapter())->isInstanceOf(AdapterInterface::class);
    }

    /**
     * @depends testItCanSetAuthAdapter
     * @depends testItCanSetGuzzleClient
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanDoHandle(): void
    {
        /** @var RequestInterface $mockRequest */
        $mockRequest = $this->makeEmpty(RequestInterface::class);

        /** @var Response $mockResponse */
        $mockResponse = $this->tester->grabMockService('Response');

        $response = $this->api->setDebug(true)
            ->doHandle($mockRequest, $mockResponse)
        ;

        verify($response instanceof Response);
    }

    /**
     * @return void
     */
    public function testItCanDoHandleXMLFormat(): void
    {
        /** @var Request $mockRequest */
        $mockRequest = $this->make(Request::class);
        $mockRequest->setUri('/foo');
        $mockRequest->setMethod(RequestInterface::METHOD_GET);
        $mockRequest->setFormat(RequestInterface::FORMAT_XML);

        /** @var Response $mockResponse */
        $mockResponse = $this->tester->grabService('Response');
        $mockResponse->setFormat(ResponseInterface::FORMAT_XML);

        $response = $this->api->doHandle($mockRequest, $mockResponse);

        verify($response instanceof Response);
    }
}
