<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\TransformerAwareTrait;
use Codeception\TestAsset\DummyTransformer;
use ReflectionException;
use UnitTester;

class TransformerAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     * @return void
     */
    public function testItCanSetTransformer(): void
    {
        /** @var TransformerAwareTrait $mock */
        $mock = $this->getMockForTrait(TransformerAwareTrait::class);
        verify(method_exists($mock, 'setTransformer'))->true();
        $dummy = new DummyTransformer($this->tester->getServiceManager());
        verify($mock->setTransformer($dummy))->isInstanceOf(get_class($mock));
    }

    /**
     * @depends testItCanSetTransformer
     * @throws ReflectionException
     * @return void
     */
    public function testItCanGetTransformer(): void
    {
        /** @var TransformerAwareTrait $mock */
        $mock = $this->getMockForTrait(TransformerAwareTrait::class);
        verify(method_exists($mock, 'getTransformer'))->true();
        verify($mock->getTransformer())->isEmpty();
        $dummy = new DummyTransformer($this->tester->getServiceManager());
        $mock->setTransformer($dummy);
        verify($mock->getTransformer())->isInstanceOf(get_class($dummy));
    }
}