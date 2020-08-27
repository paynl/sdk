<?php

declare(strict_types=1);

namespace Tests\PayNL\Sdk\unit\Model\Member;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Common\DateTime;
use PayNL\Sdk\Model\Member\CreatedAtAwareTrait;
use UnitTester,
    ReflectionException;

/**
 * Class CreatedAtAwareTraitTest
 *
 * @package Tests\PayNL\Sdk\unit\Model\Member
 */
class CreatedAtAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetCreatedAt(): void
    {
        /** @var CreatedAtAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(CreatedAtAwareTrait::class);

        $this->tester->assertObjectHasMethod('setCreatedAt', $traitCls);
        $this->tester->assertObjectMethodIsPublic('setCreatedAt', $traitCls);

        $createdAt = DateTime::now();

        $result = $traitCls->setCreatedAt($createdAt);
        verify($result)->isInstanceOf(get_class($traitCls));
        verify($result)->same($traitCls);
    }

    /**
     * @depends testItCanSetCreatedAt
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetCreatedAt(): void
    {
        /** @var CreatedAtAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(CreatedAtAwareTrait::class);

        $this->tester->assertObjectHasMethod('getCreatedAt', $traitCls);
        $this->tester->assertObjectMethodIsPublic('getCreatedAt', $traitCls);

        $createdAt = $traitCls->getCreatedAt();
        verify($createdAt)->isInstanceOf(DateTime::class);

        $now = DateTime::now();
        $traitCls->setCreatedAt($now);

        $result = $traitCls->getCreatedAt();
        verify($result)->isInstanceOf(DateTime::class);
        verify($result)->same($now);
        verify($result)->notSame($createdAt);
    }
}
