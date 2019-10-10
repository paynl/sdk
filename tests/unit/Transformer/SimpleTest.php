<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Simple as SimpleTransformer,
    TransformerInterface
};
use stdClass;

/**
 * Class SimpleTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class SimpleTest extends UnitTest
{
    /**
     * @var SimpleTransformer
     */
    protected $simpleTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->simpleTransformer = new SimpleTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->simpleTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->simpleTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformToStdClass(): void
    {
        $input = json_encode([
            'some_key' => 'a_value',
            'another_random_key' => 'Autobots, roll out!!'
        ]);

        $output = $this->simpleTransformer->transform($input);
        verify($output)->isInstanceOf(stdClass::class);
        verify($output)->hasAttribute('some_key');
        verify($output)->hasAttribute('another_random_key');
        verify($output->some_key)->equals('a_value');
        verify($output->another_random_key)->equals('Autobots, roll out!!');
    }
}
