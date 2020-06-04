<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model\Member;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    Member\LinksAwareTrait,
    Links,
    Link
};
use ReflectionException;
use UnitTester;


/**
 * Class LinksTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model\Member
 */
class LinksTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        /** @var LinksAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(LinksAwareTrait::class);

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
        /** @var LinksAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(LinksAwareTrait::class);

        verify(method_exists($traitCls, 'getLinks'))->true();

        verify($traitCls->getLinks())->isEmpty();

        /** @var Links $links */
        $links = $this->tester->grabService('modelManager')->get('Links');

        /** @var Link $link */
        $link = $this->tester->grabService('modelManager')->get('Link');
        $link->setRel('self');
        $link->setType('GET');
        $link->setUrl('https://www.pay.nl');
        $links->addLink($link);

        $traitCls->setLinks($links);

        verify($traitCls->getLinks())->isInstanceOf(Links::class);
        verify($traitCls->getLinks())->containsOnlyInstancesOf(Link::class);
        verify($traitCls->getLinks())->count(1);
    }
}
