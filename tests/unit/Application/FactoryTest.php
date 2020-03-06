<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Application;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\FactoryTestTrait;
use PayNL\Sdk\{
    Application\Application,
    Application\Factory
};
use UnitTester;

/**
 * Class FactoryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Application
 */
class FactoryTest extends UnitTest
{
    use FactoryTestTrait;

    /** @var UnitTester */
    protected $tester;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->factory = new Factory();
    }

    /**
     * @return void
     */
    public function testItCanCreateAnApplication(): void
    {
        $application = ($this->factory)($this->tester->getServiceManager(), Application::class);
        verify($application)->isInstanceOf(Application::class);
    }
}
