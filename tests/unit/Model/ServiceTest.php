<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Common\DateTime;
use PayNL\Sdk\Model\{
    Member\LinksAwareTrait,
    Service
};
use Mockery,
    Exception;

/**
 * Class ServiceTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServiceTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Service
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Service();
    }

    /**
     * @return void
     */
    public function testItIsLinksAware(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksAwareTrait::class);
    }

    /**
     * @return void
     */
    public function testItCanSetId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        $service = $this->model->setId('foo');
        verify($service)->object();
        verify($service)->same($this->model);
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
        verify($id)->notEmpty();
        verify($id)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        $service = $this->model->setName('foo');
        verify($service)->object();
        verify($service)->same($this->model);
    }

    /**
     * @depends testItCanSetName
     *
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $name = $this->model->getName();
        verify($name)->string();
        verify($name)->isEmpty();

        $this->model->setName('foo');
        $name = $this->model->getName();
        verify($name)->string();
        verify($name)->notEmpty();
        verify($name)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetDescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        $service = $this->model->setDescription('foo');
        verify($service)->object();
        verify($service)->same($this->model);
    }

    /**
     * @depends testItCanSetDescription
     *
     * @return void
     */
    public function testItCanGetDescription(): void
    {
        $this->tester->assertObjectHasMethod('getDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDescription', $this->model);

        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->isEmpty();

        $this->model->setDescription('foo');
        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->notEmpty();
        verify($description)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetTestMode(): void
    {
        $this->tester->assertObjectHasMethod('setTestMode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTestMode', $this->model);

        $service = $this->model->setTestMode(true);
        verify($service)->object();
        verify($service)->same($this->model);
    }

    /**
     * @depends testItCanSetTestMode
     *
     * @return void
     */
    public function testItCanGetTestMode(): void
    {
        $this->tester->assertObjectHasMethod('isTestMode', $this->model);
        $this->tester->assertObjectMethodIsPublic('isTestMode', $this->model);

        $testMode = $this->model->isTestMode();
        verify($testMode)->bool();
        verify($testMode)->false();

        $this->model->setTestMode(true);
        $testMode = $this->model->isTestMode();
        verify($testMode)->bool();
        verify($testMode)->true();
    }

    /**
     * @return void
     */
    public function testItCanSetSecret(): void
    {
        $this->tester->assertObjectHasMethod('setSecret', $this->model);
        $this->tester->assertObjectMethodIsPublic('setSecret', $this->model);

        $service = $this->model->setSecret('foo');
        verify($service)->object();
        verify($service)->same($this->model);
    }

    /**
     * @depends testItCanSetSecret
     *
     * @return void
     */
    public function testItCanGetSecret(): void
    {
        $this->tester->assertObjectHasMethod('getSecret', $this->model);
        $this->tester->assertObjectMethodIsPublic('getSecret', $this->model);

        $secret = $this->model->getSecret();
        verify($secret)->string();
        verify($secret)->isEmpty();

        $this->model->setSecret('foo');
        $secret = $this->model->getSecret();
        verify($secret)->string();
        verify($secret)->notEmpty();
        verify($secret)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetCreatedAt(): void
    {
        $this->tester->assertObjectHasMethod('setCreatedAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCreatedAt', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $service = $this->model->setCreatedAt($dateTimeMock);
        verify($service)->object();
        verify($service)->same($this->model);
    }

    /**
     * @depends testItCanSetCreatedAt
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetCreatedAt(): void
    {
        $this->tester->assertObjectHasMethod('getCreatedAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCreatedAt', $this->model);

        $createdAt = $this->model->getCreatedAt();
        verify($createdAt)->isInstanceOf(DateTime::class);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $this->model->setCreatedAt($dateTimeMock);
        $createdAt = $this->model->getCreatedAt();
        verify($createdAt)->notEmpty();
        verify($createdAt)->isInstanceOf(DateTime::class);
    }
}
