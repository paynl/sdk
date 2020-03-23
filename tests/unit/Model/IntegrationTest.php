<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Integration;

/**
 * Class IntegrationTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class IntegrationTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Integration
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->shouldItBeJsonSerializable = true;
        $this->model = new Integration();
    }

    /**
     * @return void
     */
    public function testItCanSetTestMode(): void
    {
        $this->tester->assertObjectHasMethod('setTestMode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTestMode', $this->model);

        $integration = $this->model->setTestMode(Integration::TEST_MODE_ON);
        verify($integration)->object();
        verify($integration)->same($this->model);
    }

    /**
     * @depends testItCanSetTestMode
     *
     * @return void
     */
    public function testItCanCheckItIsInTestMode(): void
    {
        $this->tester->assertObjectHasMethod('isTestMode', $this->model);
        $this->tester->assertObjectMethodIsPublic('isTestMode', $this->model);

        $testMode = $this->model->isTestMode();
        verify($testMode)->bool();
        verify($testMode)->equals(Integration::TEST_MODE_OFF);

        $this->model->setTestMode(Integration::TEST_MODE_ON);
        $testMode = $this->model->isTestMode();
        verify($testMode)->bool();
        verify($testMode)->equals(Integration::TEST_MODE_ON);
    }
}
