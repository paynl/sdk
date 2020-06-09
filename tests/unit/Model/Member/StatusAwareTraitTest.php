<?php

declare(strict_types=1);

namespace Tests\PayNL\Sdk\unit\Model\Member;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    Status,
    Member\StatusAwareTrait
};
use UnitTester,
    DateTime,
    ReflectionException;

/**
 * Class StatusAwareTraitTest
 *
 * @package Tests\PayNL\Sdk\unit\Model\Member
 */
class StatusAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetStatus(): void
    {
        /** @var StatusAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(StatusAwareTrait::class);

        $this->tester->assertObjectHasMethod('setStatus', $traitCls);
        $this->tester->assertObjectMethodIsPublic('setStatus', $traitCls);

        /** @var Status $status */
        $status = $this->tester->grabService('modelManager')->get('Status');

        $result = $traitCls->setStatus($status);
        verify($result)->isInstanceOf(get_class($traitCls));
        verify($result)->same($traitCls);
    }

    /**
     * @depends testItCanSetStatus
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetStatus(): void
    {
        /** @var StatusAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(StatusAwareTrait::class);

        $this->tester->assertObjectHasMethod('getStatus', $traitCls);
        $this->tester->assertObjectMethodIsPublic('getStatus', $traitCls);

        $status = $traitCls->getStatus();
        verify($status)->isInstanceOf(Status::class);
        verify($status->getCode())->isEmpty();
        verify($status->getName())->isEmpty();
        verify($status->getDate())->isInstanceOf(DateTime::class);
        verify($status->getReason())->isEmpty();


        /** @var Status $statusModel */
        $statusModel = $this->tester->grabService('modelManager')->get('Status');
        $statusModel->setCode(100);
        $statusModel->setName('foo');
        $statusModel->setDate(new DateTime());
        $statusModel->setReason('bar');
        $traitCls->setStatus($statusModel);

        $result = $traitCls->getStatus();
        verify($result)->isInstanceOf(Status::class);
        verify($result)->same($statusModel);
        verify($result)->notSame($status);
    }
}
