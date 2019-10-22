<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\Terminals as TerminalsHydrator,
    Model\Terminals,
    Model\Terminal
};
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class TerminalsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class TerminalsTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new TerminalsHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptATerminalsModel(): void
    {
        $hydrator = new TerminalsHydrator();
        expect($hydrator->hydrate(['terminals' => []], new Terminals()))->isInstanceOf(Terminals::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new TerminalsHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new TerminalsHydrator();
        $terminals = $hydrator->hydrate([
            'terminals' => [
                [
                    'id'          => 'TT-0000-0000-0000',
                    'name'        => 'Terminal New York #5.',
                    'ecrProtocol' => 'WEB',
                    'state'       => 'active',
                ],
            ],
        ], new Terminals());

        expect($terminals->getTerminals())->array();
        expect($terminals->getTerminals())->count(1);
        expect($terminals->getTerminals())->containsOnlyInstancesOf(Terminal::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new TerminalsHydrator();
        $terminals = $hydrator->hydrate([
            'terminals' => [
                [
                    'id'          => 'TT-0000-0000-0000',
                    'name'        => 'Terminal New York #5.',
                    'ecrProtocol' => 'WEB',
                    'state'       => 'active',
                ],
            ],
        ], new Terminals());

        $data = $hydrator->extract($terminals);
        $this->assertIsArray($data);
        verify($data)->hasKey('terminals');

        expect($data['terminals'])->array();
        expect($data['terminals'])->count(1);
        expect($data['terminals'])->containsOnlyInstancesOf(Terminal::class);
    }
}
