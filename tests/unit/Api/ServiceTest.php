<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Api;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Api\Api,
    Api\Service,
    Request\AbstractRequest,
    Request\RequestInterface,
    Response\Response,
    Service\Manager as ServiceManager
};
use Exception,
    UnitTester,
    Mockery\MockInterface
;

/**
 * Class ServiceTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class ServiceTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @var ServiceManager
     */
    protected $serviceManagerMock;

    /**
     * @var Api | MockInterface
     */
    protected $apiMock;

    /**
     * @throws Exception
     *
     * @return void
     */
    public function _before(): void
    {
        $mockApi = $this->tester->grabMockService('Api');
        $this->apiMock = $mockApi;

        $this->service = new Service($this->apiMock, $this->tester->getServiceManager());
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        $this->service = new Service(
            $this->tester->grabMockService('Api'),
            $this->tester->getServiceManager()
        );
        verify($this->service)->object();
        verify($this->service)->isInstanceOf(Service::class);
    }

    /**
     * @return void
     */
    public function testItCanSetRequest(): void
    {
        $requestMock = $this->tester->grabMockService('requestManager')
            ->get('Request', ['uri' => 'test/1']);

        $service = $this->service->setRequest($requestMock);
        verify($service)->isInstanceOf(Service::class);
        verify($service)->same($this->service);
    }

    /**
     * @depends testItCanSetRequest
     *
     * @return void
     */
    public function testItCanGetRequest(): void
    {
        $requestMock = $this->tester->grabMockService('requestManager')
            ->get('Request', ['uri' => 'test/1']);

        $this->service->setRequest($requestMock);
        $request = $this->service->getRequest();
        verify($request)->isInstanceOf(RequestInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanSetResponse(): void
    {
        $responseMock = $this->tester->grabMockService('Response');
        $service = $this->service->setResponse($responseMock);
        verify($service)->isInstanceOf(Service::class);
        verify($service)->same($this->service);
    }

    /**
     * @depends testItCanSetResponse
     *
     * @return void
     */
    public function testItCanGetResponse(): void
    {
        $responseMock = $this->tester->grabMockService('Response');
        $this->service->setResponse($responseMock);
        $response = $this->service->getResponse();
        verify($response)->isInstanceOf(Response::class);
    }

    public function testItCanHandle(): void
    {
        /** @var MockInterface | AbstractRequest $requestMock */
        $requestMock = $this->tester->grabMockService('requestManager')
            ->get('Request', [
                'uri'     => 'test/1',
            ])
        ;

        /** @var Response $responseMock */
        $responseMock = $this->tester->grabMockService('Response');

        $this->service->setRequest($requestMock)
            ->setResponse($responseMock)
            ->handle()
        ;

        $requestMock->shouldHaveReceived('getHeaders');
        $this->apiMock->shouldHaveReceived('doHandle')
            ->with($requestMock, $responseMock);
    }
}
