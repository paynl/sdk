<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Model\DirectdebitOverview,
    Model\LinksTrait,
    Model\Mandate,
    Model\Directdebits
};

/**
 * Class DirectdebitOverview
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class DirectdebitOverviewTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var DirectdebitOverview
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new DirectdebitOverview();
    }

    /**
     * @return void
     */
    public function testItIsLinkAware(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksTrait::class);
    }

    /**
     * @return Mandate
     */
    private function getMockMandate(): Mandate
    {
        return $this->tester->grabMockService('modelManager')->get(Mandate::class);
    }

    /**
     * @return Directdebits
     */
    private function getMockDirectdebits(): Directdebits
    {
        return $this->tester->grabMockService('modelManager')->get(Directdebits::class);
    }

    /**
     * @return void
     */
    public function testItCanSetMandate(): void
    {
        $this->tester->assertObjectHasMethod('setMandate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setMandate', $this->model);

        $directdebitOverview = $this->model->setMandate($this->getMockMandate());
        verify($directdebitOverview)->object();
        verify($directdebitOverview)->same($this->model);
    }

    /**
     * @depends testItCanSetMandate
     *
     * @return void
     */
    public function testItCanGetMandate(): void
    {
        $this->tester->assertObjectHasMethod('getMandate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getMandate', $this->model);

        $mockMandate = $this->getMockMandate();
        $this->model->setMandate($mockMandate);
        $mandate = $this->model->getMandate();
        verify($mandate)->object();
        verify($mandate)->isInstanceOf(Mandate::class);
    }

    /**
     * @return void
     */
    public function testItCanSetDirectdebits(): void
    {
        $this->tester->assertObjectHasMethod('setDirectdebits', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDirectdebits', $this->model);

        $directdebitOverview = $this->model->setDirectdebits($this->getMockDirectdebits());
        verify($directdebitOverview)->object();
        verify($directdebitOverview)->same($this->model);
    }

    /**
     * @depends testItCanSetDirectdebits
     *
     * @return void
     */
    public function testItCanGetDirectdebits(): void
    {
        $this->tester->assertObjectHasMethod('getDirectdebits', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDirectdebits', $this->model);

        $mockDirectdebits = $this->getMockDirectdebits();
        $this->model->setDirectdebits($mockDirectdebits);
        $message = $this->model->getDirectdebits();
        verify($message)->object();
        verify($message)->isInstanceOf(Directdebits::class);
        verify($message)->same($mockDirectdebits);
    }
}
