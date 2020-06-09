<?php

declare(strict_types=1);

namespace Tests\PayNL\Sdk\unit\Model\Member;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    BankAccount,
    Member\BankAccountAwareTrait
};
use UnitTester,
    ReflectionException;

/**
 * Class BankAccountAwareTraitTest
 *
 * @package Tests\PayNL\Sdk\unit\Model\Member
 */
class BankAccountAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetBankAccount(): void
    {
        /** @var BankAccountAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(BankAccountAwareTrait::class);

        $this->tester->assertObjectHasMethod('setBankAccount', $traitCls);
        $this->tester->assertObjectMethodIsPublic('setBankAccount', $traitCls);

        /** @var BankAccount $bankAccount */
        $bankAccount = $this->tester->grabService('modelManager')->get('BankAccount');

        $result = $traitCls->setBankAccount($bankAccount);
        verify($result)->isInstanceOf(get_class($traitCls));
        verify($result)->same($traitCls);
    }

    /**
     * @depends testItCanSetBankAccount
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetBankAccount(): void
    {
        /** @var BankAccountAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(BankAccountAwareTrait::class);

        $this->tester->assertObjectHasMethod('getBankAccount', $traitCls);
        $this->tester->assertObjectMethodIsPublic('getBankAccount', $traitCls);

        $bankAccount = $traitCls->getBankAccount();
        verify($bankAccount)->isInstanceOf(BankAccount::class);
        verify($bankAccount->getBank())->isEmpty();
        verify($bankAccount->getBic())->isEmpty();
        verify($bankAccount->getIban())->isEmpty();
        verify($bankAccount->getOwner())->isEmpty();
        verify($bankAccount->getReturnUrl())->isEmpty();

        /** @var BankAccount $bankAccountModel */
        $bankAccountModel = $this->tester->grabService('modelManager')->get('BankAccount');
        $bankAccountModel->setBank('FooBar');
        $bankAccountModel->setBic('BAZ');
        $bankAccountModel->setIban('NL00FBAR0000000');
        $bankAccountModel->setOwner('Corge');
        $bankAccountModel->setReturnUrl('https://fred.waldo.thud');
        $traitCls->setBankAccount($bankAccountModel);

        $result = $traitCls->getBankAccount();
        verify($result)->isInstanceOf(BankAccount::class);
        verify($result)->same($bankAccountModel);
        verify($result)->notSame($bankAccount);
    }
}
