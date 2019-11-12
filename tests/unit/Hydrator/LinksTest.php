<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\Links as LinksHydrator,
    Model\Links,
    Model\Link
};
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class LinksTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class LinksTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new LinksHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptALinksModel(): void
    {
        $hydrator = new LinksHydrator();
        expect($hydrator->hydrate([], new Links()))->isInstanceOf(Links::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new LinksHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new LinksHydrator();
        $links = $hydrator->hydrate([
            [
                'rel'  => 'self',
                'type' => 'GET',
                'url'  => 'http://www.pay.nl'
            ]
        ], new Links());

        expect($links->getLinks())->array();
        expect($links->getLinks())->count(1);
        expect($links->getLinks())->containsOnlyInstancesOf(Link::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new LinksHydrator();
        $links = $hydrator->hydrate([
            [
                'rel'  => 'self',
                'type' => 'GET',
                'url'  => 'http://www.pay.nl'
            ]
        ], new Links());

        $data = $hydrator->extract($links);
        $this->assertIsArray($data);
        verify($data)->hasKey('links');

        expect($data['links'])->array();
        expect($data['links'])->count(1);
        expect($data['links'])->containsOnlyInstancesOf(Link::class);
    }
}
