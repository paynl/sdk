<?php

use Codeception\TestAsset\Dummy;
use Codeception\TestAsset\SimpleDummyMapper;
use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;

class AbstractMapperTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var SimpleDummyMapper
     */
    protected $mapper;

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        $this->mapper = new SimpleDummyMapper([
            Dummy::class => Dummy::class
        ]);
    }

    /**
     * @return void
     */
    public function testItCanGetSourceFromString(): void
    {
        $result = $this->mapper->getSource(Dummy::class);
        verify($result)->string();
        verify($result)->equals(Dummy::class);
    }

    /**
     * @return void
     */
    public function testItCanGetSourceFromObject(): void
    {
        $result = $this->mapper->getSource(new Dummy());
        verify($result)->string();
        verify($result)->equals(Dummy::class);
    }

    /**
     * @return void
     */
    public function testItThrowsExceptionGetSourceFromNonStringOrObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->mapper->getSource([]);
    }

    /**
     * @return void
     */
    public function testItCanGetTargetFromString(): void
    {
        $result = $this->mapper->getTarget(Dummy::class);
        verify($result)->string();
        verify($result)->equals(Dummy::class);
    }

    /**
     * @return void
     */
    public function testItCanGetTargetFromObject(): void
    {
        $result = $this->mapper->getTarget(new Dummy());
        verify($result)->string();
        verify($result)->equals(Dummy::class);
    }

    /**
     * @return void
     */
    public function testItThrowsExceptionGetTargetFromNonStringOrObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mapper->getTarget([]);
    }

}