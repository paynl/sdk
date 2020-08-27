<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\CompanyCard;

/**
 * Class CompanyCard
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CompanyCardTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var CompanyCard
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new CompanyCard();
    }

    /**
     * @return void
     */
    public function testItCanSetId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        $companyCard = $this->model->setId('foo');
        verify($companyCard)->object();
        verify($companyCard)->same($this->model);
    }

    /**
     * @depends testItCanSetId
     *
     * @return void
     */
    public function testItCanGetId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $id = $this->model->getId();
        verify($id)->string();
        verify($id)->isEmpty();

        $this->model->setId('foo');
        $id = $this->model->getId();
        verify($id)->string();
        verify($id)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetToken(): void
    {
        $this->tester->assertObjectHasMethod('setToken', $this->model);
        $this->tester->assertObjectMethodIsPublic('setToken', $this->model);

        $companyCard = $this->model->setToken('foo');
        verify($companyCard)->object();
        verify($companyCard)->same($this->model);
    }

    /**
     * @depends testItCanSetToken
     *
     * @return void
     */
    public function testItCanGetToken(): void
    {
        $this->tester->assertObjectHasMethod('getToken', $this->model);
        $this->tester->assertObjectMethodIsPublic('getToken', $this->model);

        $token = $this->model->getToken();
        verify($token)->string();
        verify($token)->isEmpty();

        $this->model->setToken('foo');
        $token = $this->model->getToken();
        verify($token)->string();
        verify($token)->notEmpty();
        verify($token)->equals('foo');
    }
}
