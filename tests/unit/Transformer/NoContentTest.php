<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    NoContent as NoContentTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\Currency;

/**
 * Class NoContentTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class NoContentTest extends UnitTest
{
    /**
     * @var NoContentTransformer
     */
    protected $noContentTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->noContentTransformer = new NoContentTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->noContentTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItDoesNotExtendAbstract(): void
    {
        verify($this->noContentTransformer)->isNotInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItOnlyReturnsAnEmptyArray(): void
    {
        $output = $this->noContentTransformer->transform('');
        verify($output)->array();
        verify($output)->isEmpty();
    }
}
