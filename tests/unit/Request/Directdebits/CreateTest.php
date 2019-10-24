<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Directdebits;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Directdebits\Create,
    RequestInterface,
    AbstractRequest
};
use PayNL\Sdk\Model\Mandate;
use PayNL\Sdk\Transformer\{
    Directdebit,
    TransformerInterface
};

/**
 * Class CreateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Directdebits
 */
class CreateTest extends UnitTest
{
    /**
     * @var Create
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var Mandate $mandateMock */
        $mandateMock = $this->createMock(Mandate::class);
        $this->request = new Create($mandateMock);
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->request)->isInstanceOf(RequestInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->request)->isInstanceOf(AbstractRequest::class);
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('directdebits');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_POST);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        verify(method_exists($this->request, 'getTransformer'));
        verify($this->request->getTransformer())->isInstanceOf(TransformerInterface::class);
        verify($this->request->getTransformer())->isInstanceOf(Directdebit::class);
    }
}
