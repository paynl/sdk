<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\Terminal as TerminalHydrator;
use PayNL\Sdk\Model\Terminal;
use Zend\Hydrator\HydratorInterface;

/**
 * Class TerminalTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class TerminalTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new TerminalHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new TerminalHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new Terminal()))->isInstanceOf(Terminal::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new TerminalHydrator();
        $terminal = $hydrator->hydrate([
            'id'          => 'TT-0000-0000-0000',
            'name'        => 'Terminal New York #5.',
            'ecrProtocol' => 'WEB',
            'state'       => 'active',
        ], new Terminal());

        expect($terminal->getId())->string();
        expect($terminal->getId())->equals('TT-0000-0000-0000');
        expect($terminal->getName())->string();
        expect($terminal->getName())->equals('Terminal New York #5.');
        expect($terminal->getEcrProtocol())->string();
        expect($terminal->getEcrProtocol())->equals('WEB');
        expect($terminal->getState())->string();
        expect($terminal->getState())->equals('active');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new TerminalHydrator();
        $terminal = $hydrator->hydrate([
            'id'          => 'TT-0000-0000-0000',
            'name'        => 'Terminal New York #5.',
            'ecrProtocol' => 'WEB',
            'state'       => 'active',
        ], new Terminal());

        $data = $hydrator->extract($terminal);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('name');
        verify($data)->hasKey('ecrProtocol');
        verify($data)->hasKey('state');

        expect($data['id'])->string();
        expect($data['id'])->equals('TT-0000-0000-0000');
        expect($data['name'])->string();
        expect($data['name'])->equals('Terminal New York #5.');
        expect($data['ecrProtocol'])->string();
        expect($data['ecrProtocol'])->equals('WEB');
        expect($data['state'])->string();
        expect($data['state'])->equals('active');
    }
}
