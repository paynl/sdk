<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Link
};
use JsonSerializable;

/**
 * Class LinkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class LinkTest extends UnitTest
{
    /**
     * @var Link
     */
    protected $link;

    public function _before(): void
    {
        $this->link = new Link();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->link)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->link)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetARel(): void
    {
        verify(method_exists($this->link, 'setRel'))->true();
        expect($this->link->setRel('self'))->isInstanceOf(Link::class);
    }

    /**
     * @depends testItCanSetARel
     *
     * @return void
     */
    public function testItCanGetARel(): void
    {
        verify(method_exists($this->link, 'getRel'))->true();

        $this->link->setRel('self');

        verify($this->link->getRel())->string();
        verify($this->link->getRel())->notEmpty();
        verify($this->link->getRel())->equals('self');
    }

    /**
     * @return void
     */
    public function testItCanSetAType(): void
    {
        verify(method_exists($this->link, 'setType'))->true();
        expect($this->link->setType('GET'))->isInstanceOf(Link::class);
    }

    /**
     * @depends testItCanSetAType
     *
     * @return void
     */
    public function testItCanGetAType(): void
    {
        verify(method_exists($this->link, 'getType'))->true();

        $this->link->setType('GET');

        verify($this->link->getType())->string();
        verify($this->link->getType())->notEmpty();
        verify($this->link->getType())->equals('GET');
    }

    /**
     * @return void
     */
    public function testItCanSetAnUrl(): void
    {
        verify(method_exists($this->link, 'setUrl'))->true();
        expect($this->link->setUrl('http://www.pay.nl'))->isInstanceOf(Link::class);
    }

    /**
     * @depends testItCanSetAnUrl
     *
     * @return void
     */
    public function testItCanGetAnUrl(): void
    {
        verify(method_exists($this->link, 'getUrl'))->true();

        $this->link->setUrl('http://www.pay.nl');

        verify($this->link->getUrl())->string();
        verify($this->link->getUrl())->notEmpty();
        verify($this->link->getUrl())->equals('http://www.pay.nl');
    }
}
