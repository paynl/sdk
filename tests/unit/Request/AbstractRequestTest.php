<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request;

use Codeception\Test\Unit as UnitTest;
use PayNL\GuzzleHttp\{
    Client,
    Exception\ClientException,
    Psr7\Request,
    Psr7\Response as Psr7Response,
    Handler\MockHandler
};
use Codeception\TestAsset\DummyFilter;
use PayNL\Sdk\{Exception\InvalidArgumentException,
    Filter\FilterInterface,
    Response\Response,
    Request\RequestInterface,
    Request\AbstractRequest,
    Response\ResponseInterface,
    Transformer\TransformerInterface};
use TypeError, UnitTester;

/**
 * Class AbstractRequestTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request
 */
class AbstractRequestTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractRequest
     */
    protected $anonymousClassFromAbstract;

    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class() extends AbstractRequest {
            public function getMethod(): string
            {
                return 'GET';
            }

            public function getUri(): string
            {
                return 'api/some/endpoint';
            }

            public function getTransformer(): TransformerInterface
            {
                return new Simple();
            }
        };
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(RequestInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAFormat(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'setFormat'))->true();
        verify($this->anonymousClassFromAbstract->setFormat(RequestInterface::FORMAT_JSON))
            ->isInstanceOf(AbstractRequest::class)
        ;
    }

    /**
     * @depends testItCanSetAFormat
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenSettingAnIncorrectFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->anonymousClassFromAbstract->setFormat('NotSupportedFormat');
    }

    /**
     * @depends testItCanSetAFormat
     *
     * @return void
     */
    public function testItCanGetTheFormat(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getFormat'))->true();

        $this->anonymousClassFromAbstract->setFormat(RequestInterface::FORMAT_JSON);

        verify($this->anonymousClassFromAbstract->getFormat())->string();
        verify($this->anonymousClassFromAbstract->getFormat())->notEmpty();
        verify($this->anonymousClassFromAbstract->getFormat())->equals(RequestInterface::FORMAT_JSON);
    }

    /**
     * @depends testItCanSetAFormat
     * @depends testItCanGetTheFormat
     *
     * @return void
     */
    public function testItHasFormatObjectsAsDefaultFormat(): void
    {
        verify($this->anonymousClassFromAbstract->getFormat())->string();
        verify($this->anonymousClassFromAbstract->getFormat())->notEmpty();
        verify($this->anonymousClassFromAbstract->getFormat())->equals(RequestInterface::FORMAT_OBJECTS);
    }

    /**
     * @return void
     */
    public function testItCanGetHeaders(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getHeaders'))->true();
        verify($this->anonymousClassFromAbstract->getHeaders())->array();
    }

    /**
     * @depends testItCanGetHeaders
     *
     * @return void
     */
    public function testItHasDefaultAnEmptyArrayAsHeaderCollection(): void
    {
        verify($this->anonymousClassFromAbstract->getHeaders())->array();
        verify($this->anonymousClassFromAbstract->getHeaders())->isEmpty();
    }

    /**
     * @depends testItCanGetHeaders
     *
     * @return void
     */
    public function testItCanAddHeader(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'setHeader'))->true();
        verify($this->anonymousClassFromAbstract->setHeader('X-Test-Header', 'Test-value'))
            ->isInstanceOf(AbstractRequest::class)
        ;

        $headers = $this->anonymousClassFromAbstract->getHeaders();
        verify($headers)->hasKey('X-Test-Header');
        verify($headers['X-Test-Header'])->string();
        verify($headers['X-Test-Header'])->notEmpty();
        verify($headers['X-Test-Header'])->equals('Test-value');
    }

    /**
     * @depends testItCanAddHeader
     * @depends testItCanGetHeaders
     *
     * @return void
     */
    public function testItCanSetHeaders(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'setHeaders'))->true();
        verify($this->anonymousClassFromAbstract->setHeaders([
            'X-Custom-header1' => 'Value1',
            'X-Custom-header2' => 'Value2',
        ]))->isInstanceOf(AbstractRequest::class);

        verify($this->anonymousClassFromAbstract->getHeaders())->count(2);
    }

    /**
     * @depends testItCanAddHeader
     * @depends testItCanSetHeaders
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAddingWrongHeaderName(): void
    {
        $this->expectException(TypeError::class);
        $this->anonymousClassFromAbstract->setHeaders([1.0, '']);
    }

    /**
     * @depends testItCanAddHeader
     * @depends testItCanSetHeaders
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAddingWrongHeaderValue(): void
    {
        $this->expectException(TypeError::class);
        $this->anonymousClassFromAbstract->setHeaders(['', 1.0]);
    }

    /**
     * @depends testItCanAddHeader
     * @depends testItCanGetHeaders
     *
     * @return void
     */
    public function testItCanGetSpecificHeader(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getHeader'))->true();

        $this->anonymousClassFromAbstract->setHeader('X-Custom-header', 'SomeValue');

        $header = $this->anonymousClassFromAbstract->getHeader('X-Custom-header');
        verify($header)->string();
        verify($header)->notEmpty();
        verify($header)->equals('SomeValue');
    }

    /**
     * @depends testItCanGetSpecificHeader
     *
     * @return void
     */
    public function testItReturnsNullWhenNotFindingSpecificHeader(): void
    {
        $header = $this->anonymousClassFromAbstract->getHeader('X-NonExisting-HeaderName');
        verify($header)->null();
    }

    /**
     * @depends testItCanAddHeader
     * @depends testItCanGetTheFormat
     * @depends testItCanGetSpecificHeader
     *
     * @return void
     */
    public function testItCanEncodeInputToJson(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'encodeBody'))->true();

        $this->anonymousClassFromAbstract->setFormat(RequestInterface::FORMAT_JSON);

        $encodedOutPut = $this->tester->invokeMethod(
            $this->anonymousClassFromAbstract,
            'encodeBody',
            [
                ['test', 'test2'],
                'a string',
                1.0
            ]
        );

        verify(@json_decode($encodedOutPut, false))->notNull();
        verify($this->anonymousClassFromAbstract->getHeader(AbstractRequest::HEADER_CONTENT_TYPE))->string();
        verify($this->anonymousClassFromAbstract->getHeader(AbstractRequest::HEADER_CONTENT_TYPE))->notEmpty();
        verify($this->anonymousClassFromAbstract->getHeader(AbstractRequest::HEADER_CONTENT_TYPE))
            ->equals('application/json')
        ;
    }

    /**
     * @depends testItCanAddHeader
     * @depends testItCanGetTheFormat
     * @depends testItCanGetSpecificHeader
     *
     * @return void
     */
    public function testItCanEncodeInputToXml(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'encodeBody'))->true();

        $this->anonymousClassFromAbstract->setFormat(RequestInterface::FORMAT_XML);

        $encodedOutPut = $this->tester->invokeMethod(
            $this->anonymousClassFromAbstract,
            'encodeBody',
            [
                ['test', 'test2'],
                'a string',
                1.0
            ]
        );


        verify(@simplexml_load_string($encodedOutPut))->notEquals(false);
        verify(@simplexml_load_string($encodedOutPut)->getName())->equals(AbstractRequest::XML_ROOT_NODE_NAME);
        verify($this->anonymousClassFromAbstract->getHeader(AbstractRequest::HEADER_CONTENT_TYPE))->string();
        verify($this->anonymousClassFromAbstract->getHeader(AbstractRequest::HEADER_CONTENT_TYPE))->notEmpty();
        verify($this->anonymousClassFromAbstract->getHeader(AbstractRequest::HEADER_CONTENT_TYPE))
            ->equals('application/xml')
        ;
    }

    /**
     * @depends testItCanEncodeInputToJson
     * @depends testItCanEncodeInputToXml
     *
     * @return void
     */
    public function testItCanSetABody(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'setBody'))->true();

        verify($this->anonymousClassFromAbstract->setBody('This is a test string'))
            ->isInstanceOf(AbstractRequest::class)
        ;

        verify($this->anonymousClassFromAbstract->setBody([ 'test', 'test2' ]))
            ->isInstanceOf(AbstractRequest::class)
        ;

        verify($this->anonymousClassFromAbstract->setBody([
            ['test', 'test2'],
            'a string',
            1.0
        ]))->isInstanceOf(AbstractRequest::class);
    }

    /**
     * @depends testItCanSetABody
     *
     * @return void
     */
    public function testItCanGetABody(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getBody'))->true();

        verify($this->anonymousClassFromAbstract->getBody())->string();
        verify($this->anonymousClassFromAbstract->getBody())->isEmpty();

        $this->anonymousClassFromAbstract->setBody('test');

        verify($this->anonymousClassFromAbstract->getBody())->notEmpty();
    }

    /**
     * @before testItCanApplyAGuzzleClient
     * @before testItCanGetTheGuzzleClient
     *
     * @return void
     */
    public function setUpMockGuzzleClient(): void
    {
        $this->guzzleClient = $this->createMock(Client::class);
    }

    /**
     * @return void
     */
    public function testItCanApplyAGuzzleClient(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'applyClient'))->true();

        verify($this->guzzleClient)->isInstanceOf(Client::class);

        verify($this->anonymousClassFromAbstract->applyClient($this->guzzleClient))
            ->isInstanceOf(AbstractRequest::class)
        ;
    }

    /**
     * @depends testItCanApplyAGuzzleClient
     *
     * @return void
     */
    public function testItCanGetTheGuzzleClient(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getClient'))->true();

        verify($this->guzzleClient)->isInstanceOf(Client::class);

        verify($this->anonymousClassFromAbstract->getClient())->isEmpty();

        $this->anonymousClassFromAbstract->applyClient($this->guzzleClient);

        verify($this->anonymousClassFromAbstract->getClient())->isInstanceOf(Client::class);
    }

    public function testItCanGetFilters(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getFilters'))->true();
        verify($this->anonymousClassFromAbstract->getHeaders())->array();
    }

    /**
     * @depends testItCanGetFilters
     *
     * @return void
     */
    public function testItHasDefaultAnEmptyArrayAsFiltersCollection(): void
    {
        verify($this->anonymousClassFromAbstract->getFilters())->array();
        verify($this->anonymousClassFromAbstract->getFilters())->isEmpty();
    }

    /**
     * @depends testItCanGetFilters
     *
     * @return void
     */
    public function testItCanAddFilter(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'addFilter'))->true();
        $filter = new DummyFilter();

        verify($this->anonymousClassFromAbstract->addFilter($filter))
            ->isInstanceOf(AbstractRequest::class)
        ;

        $filters = $this->anonymousClassFromAbstract->getFilters();
        verify($filters)->hasKey('DummyFilter');
        verify($filters['DummyFilter'])->notEmpty();
        verify($filters['DummyFilter'])->isInstanceOf(FilterInterface::class);
    }

    /**
     * @depends testItCanAddFilter
     * @depends testItCanGetFilters
     *
     * @return void
     */
    public function testItCanSetFilters(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'setFilters'))->true();

        $filter = new DummyFilter();

        verify($this->anonymousClassFromAbstract->setFilters([
            $filter
        ]))->isInstanceOf(AbstractRequest::class);

        verify($this->anonymousClassFromAbstract->getFilters())->count(1);
    }

    /**
     * @depends testItCanSetFilters
     * @depends testItCanGetFilters
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAddingWrongFilter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->anonymousClassFromAbstract->setFilters([1.0,]);
    }

    /**
     * @depends testItCanAddFilter
     * @depends testItCanGetFilters
     *
     * @return void
     */
    public function testItCanGetSpecificFilter(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getFilter'))->true();

        $filter = new DummyFilter();

        $this->anonymousClassFromAbstract->addFilter($filter);

        $filterFromCollection = $this->anonymousClassFromAbstract->getFilter('DummyFilter');
        verify($filterFromCollection)->notEmpty();
        verify($filterFromCollection)->isInstanceOf(FilterInterface::class);
        verify($filterFromCollection)->same($filter);
    }

    /**
     * @depends testItCanGetSpecificFilter
     *
     * @return void
     */
    public function testItReturnsNullWhenNotFindingSpecificFilter(): void
    {
        $filter = $this->anonymousClassFromAbstract->getFilter('Bogus');
        verify($filter)->null();
    }

    /**
     * @return void
     */
    public function testItHasAnUri(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getUri'))->true();
        verify($this->anonymousClassFromAbstract->getUri())->string();
        verify($this->anonymousClassFromAbstract->getUri())->notEmpty();
    }

    /**
     * @return void
     */
    public function testItHasAMethod(): void
    {
        verify(method_exists($this->anonymousClassFromAbstract, 'getMethod'))->true();
        verify($this->anonymousClassFromAbstract->getMethod())->string();
        verify($this->anonymousClassFromAbstract->getMethod())->notEmpty();
    }

    /**
     * @depends testItHasAnUri
     * @depends testItCanGetFilters
     * @depends testItHasAMethod
     * @depends testItCanGetHeaders
     * @depends testItCanGetABody
     * @depends testItCanApplyAGuzzleClient
     * @depends testItCanGetTheGuzzleClient
     *
     * @return void
     */
    public function testItCanExecute(): void
    {
        /** @var Response $response */
        $response = $this->tester->grabService('Response');

        $guzzleMockHandler = new MockHandler();
        $guzzleMockHandler->append(new Psr7Response(200, [], '{"result": "ok"}'));

        $guzzleClient = new Client([
            'handler' => $guzzleMockHandler,
        ]);

        $filter = new DummyFilter();
        $filter->setValue('1');

        $this->anonymousClassFromAbstract
            ->setFilters([$filter])
            ->applyClient($guzzleClient)
            ->execute($response)
        ;

        verify($response->getBody())->notEmpty();
        verify($response->getBody())->string();
        verify($response->getBody())->equals('OK');
    }

    /**
     * @depends testItCanExecute
     *
     * @return void
     */
    public function testItReturnsAResponseWhenRequestIsNotSuccessful(): void
    {
        /** @var Response $response */
        $response = $this->tester->grabService('Response');
        $response->setFormat(ResponseInterface::FORMAT_JSON);

        $guzzleMockHandler = new MockHandler();
        $guzzleMockHandler->append(new Psr7Response(500));

        $guzzleClient = new Client([
            'handler' => $guzzleMockHandler,
        ]);

        $this->anonymousClassFromAbstract->applyClient($guzzleClient);

        $this->anonymousClassFromAbstract->execute($response);

        verify($response)->isInstanceOf(Response::class);
        verify($response->getStatusCode())->equals(500);
    }

    /**
     * @depends testItCanExecute
     *
     * @return void
     */
    public function testItContainsErrorsWhenNoGuzzleClientIsSet(): void
    {
        /** @var Response $response */
        $response = $this->tester->grabService('Response');
        $response->setFormat(ResponseInterface::FORMAT_JSON);

        $this->anonymousClassFromAbstract
            ->setFilters([new DummyFilter()])
            ->execute($response);

        verify($response->hasErrors())->true();
    }

    /**
     * @depends testItCanExecute
     *
     * @return void
     */
    public function testItCanProcessErrors(): void
    {
        /** @var Response $response */
        $response = $this->tester->grabService('Response');
        $response->setFormat(ResponseInterface::FORMAT_JSON);

        $guzzleMockHandler = new MockHandler();
        $guzzleMockHandler->append(new ClientException(
            "Client error: Something went wrong response:\n{\"errors\": {\"field\": {\"code\": 100, \"message\": \"exception_message\"}}}\n",
            new Request('GET', 'test'),
            new Psr7Response(400, [], '{"errors": {"field": {"code": 100, "message": "exception_message"}}}')
        ));

        $guzzleClient = new Client([
            'handler' => $guzzleMockHandler,
        ]);

        $this->anonymousClassFromAbstract->setFilters([
            new DummyFilter(),
        ])->applyClient($guzzleClient)
            ->execute($response)
        ;

        $body = $response->getBody();
        $json = json_decode($body, true);
        verify($json)->array();
        verify($json)->hasKey('errors');
    }
}
