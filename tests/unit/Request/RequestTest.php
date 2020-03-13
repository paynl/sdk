<?php

declare(strict_types=1);

namespace Test\Unit\PayNL\Sdk\Request;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Request;

/**
 * Class RequestTest
 * @package Test\Unit\PayNL\Sdk\Request
 */
class RequestTest extends UnitTest
{
    public function testItExtendsAbstractRequest(): void
    {
        $request = new Request('www.pay.nl');
        verify($request)->isInstanceOf(AbstractRequest::class);
    }
}