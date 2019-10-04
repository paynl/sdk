<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Terminal as TerminalTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\Terminal;

/**
 * Class TerminalTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class TerminalTest extends UnitTest
{
    /**
     * @var TerminalTransformer
     */
    protected $terminalTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->terminalTransformer = new TerminalTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->terminalTransformer)->isInstanceOf(TransformerInterface::class);
    }

    public function testItExtendsAbstract(): void
    {
        verify($this->terminalTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'pin' => [
                [
                    'id'          => 'T-0001',
                    'name'        => 'Terminal #1',
                    'ecrProtocol' => 'WEB',
                    'state'       => 'active',
                ],
                [
                    'id'          => 'T-0002',
                    'name'        => 'Terminal #2',
                    'ecrProtocol' => 'WEB',
                    'state'       => 'inactive',
                ],
            ],
        ]);

        $output = $this->terminalTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('pin');
        verify($output['pin'])->array();
        verify($output['pin'])->count(2);
        verify($output['pin'])->containsOnlyInstancesOf(Terminal::class);
    }
}
