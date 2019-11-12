<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Errors as ErrorsTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\Errors;

/**
 * Class ErrorsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class ErrorsTest extends UnitTest
{
    /**
     * @var ErrorsTransformer
     */
    protected $errorsTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->errorsTransformer = new ErrorsTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->errorsTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->errorsTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformToStdClass(): void
    {
        $input = json_encode([
            'errors' => [
                'error_1' => 'error_message_1',
                'error_2' => 'error_message_2',
            ]
        ]);

        $output = $this->errorsTransformer->transform($input);
        verify($output)->isInstanceOf(Errors::class);
        verify($output)->hasKey('error_1');
        verify($output)->hasKey('error_2');
    }
}
