<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Model\{
    ModelInterface,
    Link,
    Links
};
use PayNL\Sdk\Hydrator\Link as LinkHydrator;
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate;

/**
 * Class LinksTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class LinksTest extends UnitTest
{
    /**
     * @var Links
     */
    protected $links;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->links = new Links();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->links)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsATotalCollection(): void
    {
        verify($this->links)->isInstanceOf(ArrayCollection::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->links)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->links, 'setLinks'))->true();
        verify($this->links->setLinks([]))->isInstanceOf(Links::class);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->links, 'getLinks'))->true();

        $this->links->setLinks([
            (new LinkHydrator())->hydrate([
                'rel'  => 'self',
                'type' => 'GET',
                'url'  => 'http://some.url.com',
            ], new Link())
        ]);

        verify($this->links->getLinks())->array();
        verify($this->links->getLinks())->count(1);
        verify($this->links->getLinks())->hasKey('self');
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->links)->isInstanceOf(Countable::class);

        $this->links->setLinks([
            (new LinkHydrator())->hydrate([
                'rel'  => 'self',
                'type' => 'GET',
                'url'  => 'http://some.url.com',
            ], new Link())
        ]);

        verify(count($this->links))->equals(1);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->links)->isInstanceOf(ArrayAccess::class);

        $this->links->setLinks([
            (new LinkHydrator())->hydrate([
                'rel'  => 'self',
                'type' => 'GET',
                'url'  => 'http://some.url.com',
            ], new Link())
        ]);

        // offsetExists
        verify(isset($this->links['self']))->true();
        verify(isset($this->links['non_existing_key']))->false();

        // offsetGet
        verify($this->links['self'])->isInstanceOf(Link::class);

        // offsetSet
        $this->links['new'] = (new LinkHydrator())->hydrate([
            'rel'  => 'new',
            'type' => 'GET',
            'url'  => 'http://some.other-url.com',
        ], new Link());
        verify($this->links)->hasKey('new');
        verify($this->links)->count(2);

        // offsetUnset
        unset($this->links['self']);
        verify($this->links)->count(1);
        verify($this->links)->hasntKey('self');
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->links)->isInstanceOf(IteratorAggregate::class);

        $this->links->setLinks([
            (new LinkHydrator())->hydrate([
                'rel'  => 'self',
                'type' => 'GET',
                'url'  => 'http://some.url.com',
            ], new Link())
        ]);

        verify(is_iterable($this->links))->true();
    }
}
