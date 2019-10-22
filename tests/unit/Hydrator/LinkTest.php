<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\Link as LinkHydrator,
    Model\Link
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class LinkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 *
 */
class LinkTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new LinkHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptALinkModel(): void
    {
        $hydrator = new LinkHydrator();
        expect($hydrator->hydrate([], new Link()))->isInstanceOf(Link::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new LinkHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new LinkHydrator();
        $link = $hydrator->hydrate([
            'rel'  => 'self',
            'type' => 'GET',
            'url'  => 'https://www.pay.nl',
        ], new Link());

        expect($link->getRel())->string();
        expect($link->getRel())->equals('self');
        expect($link->getType())->string();
        expect($link->getType())->equals('GET');
        expect($link->getUrl())->string();
        expect($link->getUrl())->equals('https://www.pay.nl');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new LinkHydrator();
        $link = $hydrator->hydrate([
            'rel'  => 'self',
            'type' => 'GET',
            'url'  => 'https://www.pay.nl',
        ], new Link());

        $data = $hydrator->extract($link);
        $this->assertIsArray($data);
        verify($data)->hasKey('rel');
        verify($data)->hasKey('type');
        verify($data)->hasKey('url');

        expect($data['rel'])->string();
        expect($data['rel'])->equals('self');
        expect($data['type'])->string();
        expect($data['type'])->equals('GET');
        expect($data['url'])->string();
        expect($data['url'])->equals('https://www.pay.nl');
    }
}
