<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Notification;

/**
 * Class StatisticsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class NotificationTest extends UnitTest
{
    use ModelTestTrait;

    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Notification();
    }


    /**
     * @return void
     */
    public function testItCanSetType(): void
    {
        $this->tester->assertObjectHasMethod('setType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setType', $this->model);

        verify($this->model->setType('12345'))->isInstanceOf(Notification::class);
    }

    /**
     * @depends testItCanSetType
     *
     * @return void
     */
    public function testItCanGetType(): void
    {
        $this->tester->assertObjectHasMethod('getType', $this->model);
        $this->tester->assertObjectMethodIsPublic('getType', $this->model);

        $this->model->setType('Lorem ipsum dolor sit amet, consectetur adipiscing elit');

        verify($this->model->getType())->string();
        verify($this->model->getType())->notEmpty();
        verify($this->model->getType())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }

    /**
     * @return void
     */
    public function testItCanSetRecipient(): void
    {
        $this->tester->assertObjectHasMethod('setRecipient', $this->model);
        $this->tester->assertObjectMethodIsPublic('setRecipient', $this->model);
        verify($this->model->setRecipient('12345'))->isInstanceOf(Notification::class);
    }

    /**
     * @depends testItCanGetType
     *
     * @return void
     */
    public function testItCanGetRecipient(): void
    {
        $this->tester->assertObjectHasMethod('getRecipient', $this->model);
        $this->tester->assertObjectMethodIsPublic('getRecipient', $this->model);
        $this->model->setRecipient('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
        verify($this->model->getRecipient())->string();
        verify($this->model->getRecipient())->notEmpty();
        verify($this->model->getRecipient())->equals('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    }
}
