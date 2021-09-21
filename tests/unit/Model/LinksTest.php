<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Test\Unit as UnitTest,
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait
};
use PayNL\Sdk\Model\{
    Link,
    Links
};
use TypeError;

/**
 * Class LinksTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class LinksTest extends UnitTest
{
    use ModelTestTrait,
        CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
        testItCanGetCollectionName as traitTestItCanGetCollectionName;
    }

    /**
     * @var Links
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Links();
    }

    /**
     * @param string $key
     * @param string $type
     * @param string $url
     * @return Link
     */
    private function getMockLink($key = 'self', $type = 'GET', $url = 'http://some.url.com'): Link
    {
        /** @var Link $mockLink */
        $mockLink = $this->tester->grabService('modelManager')->build('Link');
        $mockLink->setRel($key);
        $mockLink->setType($type);
        $mockLink->setUrl($url);
        return $mockLink;
    }

    /**
     * @return void
     */
    public function testItCanAddLink(): void
    {
        $this->tester->assertObjectHasMethod('addLink', $this->model);
        $this->tester->assertObjectMethodIsPublic('addLink', $this->model);

        $link = $this->getMockLink();
        $links = $this->model->addLink($link);
        verify($links)->object();
        verify($links)->same($this->model);
        verify($links)->hasKey($link->getRel());
    }

    /**
     * @depends testItCanAddLink
     *
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        $this->tester->assertObjectHasMethod('setLinks', $this->model);
        $this->tester->assertObjectMethodIsPublic('setLinks', $this->model);

        $mockLink = $this->getMockLink('foo');

        $result = $this->model->setLinks([ $mockLink ]);
        verify($result)->isInstanceOf(Links::class);
        verify($result)->same($this->model);
        verify($result)->containsOnlyInstancesOf(Link::class);
        verify($result)->notEmpty();
        verify($result)->count(1);

        $result = $this->model->setLinks([
            $this->getMockLink('bar'),
            $this->getMockLink('baz')
        ]);
        verify($result)->isInstanceOf(Links::class);
        verify($result)->containsOnlyInstancesOf(Link::class);
        verify($result)->same($this->model);
        verify($result)->count(2);
        verify($result)->notContains($mockLink);
    }

    /**
     * @depends testItCanAddLink
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testSetLinksThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setLinks([$this->getMockLink(), []]);
    }

    /**
     * @depends testItCanAddLink
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanSetEmptyLinks(): void
    {
        $links = $this->model->setLinks([]);
        verify($links)->isInstanceOf(Links::class);
        verify($links)->same($this->model);
        verify($links)->count(0);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        $this->tester->assertObjectHasMethod('getLinks', $this->model);
        $this->tester->assertObjectMethodIsPublic('getLinks', $this->model);

        $link = $this->getMockLink();
        $key = $link->getRel();

        $this->model->setLinks([ $this->getMockLink() ]);
        $links = $this->model->getLinks();
        verify($links)->array();
        verify($links)->count(1);
        verify($links)->hasKey($key);
        verify($links)->containsOnlyInstancesOf(Link::class);
    }

    /**
     * @depends testItIsAnArrayCollection
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model->setLinks([ $this->getMockLink('foo') ]);

        // offsetExists
        verify(isset($this->model['foo']))->true();
        verify(isset($this->model['bar']))->false();

        // offsetGet
        verify($this->model['foo'])->isInstanceOf(Link::class);

        // offsetSet

        $this->model['baz'] = $this->getMockLink('baz', 'GET', 'http://corge.grault.garply');
        verify($this->model)->hasKey('baz');
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model['foo']);
        verify($this->model)->count(1);
        verify($this->model)->hasNotKey('foo');
    }

    /**
     * @inheritDoc
     */
    public function testItCanGetCollectionName(): void
    {
        $this->traitTestItCanGetCollectionName();
        verify($this->model->getCollectionName())->equals('links');
    }
}
