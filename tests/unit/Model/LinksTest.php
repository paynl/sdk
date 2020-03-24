<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\ModelTestTrait;
use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Model\{
    ModelInterface,
    Link,
    Links
};
use PayNL\Sdk\Common\CollectionInterface;
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate;

/**
 * Class LinksTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class LinksTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Links
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->shouldItBeJsonSerializable = false;
        $this->model = new Links();
    }

    /**
     * @return void
     */
    public function testItIsAnArrayCollection(): void
    {
        verify($this->model)->isInstanceOf(ArrayCollection::class);
    }

    /**
     * @return void
     */
    public function testItIsACollection(): void
    {
        verify($this->model)->isInstanceOf(CollectionInterface::class);
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
        $result = $this->model->setLinks([ $this->getLink() ]);
        verify($result)->isInstanceOf(Links::class);
    }

    /**
     * @depends testItCanSetLinks
     * @depends testItIsCountable
     * @return void
     */
    public function testItCanSetEmptyLinks(): void
    {
        $this->tester->assertObjectHasMethod('setLinks', $this->model);
        verify($this->model->setLinks([]))->isInstanceOf(Links::class);
        verify($this->model)->count(0);
    }

    /**
     * @return void
     */
    public function testItCanAddLink(): void
    {
        $link = $this->getLink();
        $this->model->addLink($link);
        verify($this->model)->hasKey($link->getRel());
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->model, 'getLinks'))->true();

        $link = $this->getLink();
        $key = $link->getRel();

        $this->model->setLinks([ $this->getLink() ]);

        verify($this->model->getLinks())->array();
        verify($this->model->getLinks())->count(1);
        verify($this->model->getLinks())->hasKey($key);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->model)->isInstanceOf(Countable::class);
        $this->model->setLinks([ $this->getLink() ]);
        verify(count($this->model))->equals(1);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->model)->isInstanceOf(ArrayAccess::class);

        $this->model->setLinks([ $this->getLink() ]);

        // offsetExists
        verify(isset($this->model['self']))->true();
        verify(isset($this->model['non_existing_key']))->false();

        // offsetGet
        verify($this->model['self'])->isInstanceOf(Link::class);

        // offsetSet

        $this->model['new'] = $this->getLink('new', 'GET', 'http://some.other-url.com');
        verify($this->model)->hasKey('new');
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model['self']);
        verify($this->model)->count(1);
        verify($this->model)->hasntKey('self');
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->model)->isInstanceOf(IteratorAggregate::class);

        $this->model->setLinks([ $this->getLink() ]);

        verify(is_iterable($this->model))->true();
    }
}
