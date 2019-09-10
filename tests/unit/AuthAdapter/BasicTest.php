<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\AuthAdapter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\AuthAdapter\Basic;
use UnitTester;

/**
 * Class BasicTest
 *
 * @package Tests\Unit\PayNL\Sdk\AuthAdapter
 */
class BasicTest extends UnitTest
{
    /**
     * @var Basic
     */
    protected $adapter;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     *
     * @return void
     */
    public function _before()
    {
        $username = 'KungLao';
        $password = 'IGotAMagicHat';

        $this->adapter = new Basic($username, $password);
    }

    /**
     *
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->adapter)->isInstanceOf(Basic::class);
    }

    /**
     *
     * @return void
     */
    public function testItCanRetrieveTheUsername(): void
    {
        verify($this->adapter->getUsername())->equals('KungLao');
    }

    /**
     *
     * @return void
     */
    public function testItCanSetAnUsername(): void
    {
        verify($this->tester->getMethodAccessibility($this->adapter, 'setUsername'))->equals('protected');
        $this->tester->invokeMethod($this->adapter, 'setUsername', [ 'LiuKang' ]);
        verify($this->adapter->getUsername())->equals('LiuKang');
    }

    /**
     *
     * @return void
     */
    public function testItCanRetrieveThePassword(): void
    {
        verify($this->adapter->getPassword())->equals('IGotAMagicHat');
    }

    /**
     *
     * @return void
     */
    public function testItCanSetAPassword(): void
    {
        verify($this->tester->getMethodAccessibility($this->adapter, 'setPassword'))->equals('protected');
        $this->tester->invokeMethod($this->adapter, 'setPassword', [ 'ICanBeADragon:P' ]);
        verify($this->adapter->getPassword())->equals('ICanBeADragon:P');
    }

    /**
     *
     * @return void
     */
    public function testItCanGetTheHeaderString(): void
    {
        verify($this->adapter->getHeaderString())->string();
        verify($this->adapter->getHeaderString())->equals('Basic ' . base64_encode('KungLao:IGotAMagicHat'));
    }
}
