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
use PayNL\Sdk\Common\CollectionInterface;
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate;
use UnitTester;

/**
 * Class LinksTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class LinksTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

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
    public function testItIsAnArrayCollection(): void
    {
        verify($this->links)->isInstanceOf(ArrayCollection::class);
    }

    /**
     * @return void
     */
    public function testItIsACollection(): void
    {
        verify($this->links)->isInstanceOf(CollectionInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->links)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @param string $key
     * @param string $type
     * @param string $url
     * @return Link
     */
    private function getLink($key = 'self', $type = 'GET', $url = 'http://some.url.com'): Link
    {
        /** @var Link $mockLink */
        $mockLink = $this->tester->grabService('modelManager')->get('Link');
        $mockLink->setRel($key);
        $mockLink->setType($type);
        $mockLink->setUrl($url);
        return $mockLink;
    }

    /**
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        $result = $this->links->setLinks([ $this->getLink() ]);
        verify($result)->isInstanceOf(Links::class);
    }

    /**
     * @depends testItCanSetLinks
     * @depends testItIsCountable
     * @return void
     */
    public function testItCanSetEmptyLinks(): void
    {
        $this->tester->assertObjectHasMethod('setLinks', $this->links);
        verify($this->links->setLinks([]))->isInstanceOf(Links::class);
        verify($this->links)->count(0);
    }

    /**
     * @return void
     */
    public function testItCanAddLink(): void
    {
        $link = $this->getLink();
        $this->links->addLink($link);
        $this->tester->assertArrayMustContainKeys($this->links->getKeys(), $link->getRel());
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->links, 'getLinks'))->true();

        $link = $this->getLink();
        $key = $link->getRel();

        $this->links->setLinks([ $this->getLink() ]);

        verify($this->links->getLinks())->array();
        verify($this->links->getLinks())->count(1);
        verify($this->links->getLinks())->hasKey($key);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->links)->isInstanceOf(Countable::class);
        $this->links->setLinks([ $this->getLink() ]);
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

        $this->links->setLinks([ $this->getLink() ]);

        // offsetExists
        verify(isset($this->links['self']))->true();
        verify(isset($this->links['non_existing_key']))->false();

        // offsetGet
        verify($this->links['self'])->isInstanceOf(Link::class);

        // offsetSet

        $this->links['new'] = $this->getLink('new', 'GET', 'http://some.other-url.com');
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

        $this->links->setLinks([ $this->getLink() ]);

        verify(is_iterable($this->links))->true();
    }
}
