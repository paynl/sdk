<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    LinksTrait,
    Links,
    Link
};
use ReflectionException;


/**
 * Class LinksTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class LinksTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        /** @var LinksTrait $traitCls */
        $traitCls = $this->getMockForTrait(LinksTrait::class);

        verify(method_exists($traitCls, 'setLinks'))->true();

        verify($traitCls->setLinks(new Links()))->isInstanceOf(get_class($traitCls));
    }

    /**
     * @depends testItCanSetLinks
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        /** @var LinksTrait $traitCls */
        $traitCls = $this->getMockForTrait(LinksTrait::class);

        verify(method_exists($traitCls, 'getLinks'))->true();

        verify($traitCls->getLinks())->isEmpty();

        $links = (new Links())->addLink(
            (new Link())->setRel('self')
                ->setType('GET')
                ->setUrl('https://www.pay.nl')
        );

        $traitCls->setLinks($links);

        verify($traitCls->getLinks())->isInstanceOf(Links::class);
        verify($traitCls->getLinks())->containsOnlyInstancesOf(Link::class);
        verify($traitCls->getLinks())->count(1);
    }
}
