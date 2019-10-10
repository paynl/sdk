<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Request\{
    RequestInterface,
    AbstractRequest
};
use TypeError;

/**
 * Class AbstractRequestTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request
 */
class AbstractRequestTest extends UnitTest
{
    /**
     * @var AbstractRequest
     */
    protected $anonymousClassFromAbstract;

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
        verify(method_exists($this->anonymousClassFromAbstract, 'addHeader'))->true();
        verify($this->anonymousClassFromAbstract->addHeader('X-Test-Header', 'Test-value'))
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

        $this->anonymousClassFromAbstract->addHeader('X-Custom-header', 'SomeValue');

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
}
