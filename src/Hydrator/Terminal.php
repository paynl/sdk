<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\Terminal as TerminalModel;

/**
 * Class Terminal
 *
 * @package PayNL\Sdk\Hydrator
 */
class Terminal extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return TerminalModel
     */
    public function hydrate(array $data, $object): TerminalModel
    {
        $this->validateGivenObject($object, TerminalModel::class);

        $data['id']          = $data['id'] ?? '';
        $data['name']        = $data['name'] ?? '';
        $data['ecrProtocol'] = $data['ecrProtocol'] ?? '';

        /** @var TerminalModel $terminal */
        $terminal = parent::hydrate($data, $object);
        return $terminal;
    }
}
