<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Terminals as TerminalsModel,
    Model\Terminal as TerminalModel,
    Hydrator\Terminal as TerminalHydrator
};

/**
 * Class Terminals
 *
 * @package PayNL\Sdk\Hydrator
 */
class Terminals extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return TerminalsModel
     */
    public function hydrate(array $data, $object): TerminalsModel
    {
        $this->validateGivenObject($object, TerminalsModel::class);

        // "reset" total
        $data['total'] = 0;
        foreach ($data['terminals'] as $key => $terminal) {
            if (false === ($terminal instanceof TerminalModel)) {
                $data['terminals'][$key] = (new TerminalHydrator())->hydrate($terminal, new TerminalModel());
            }
        }

        /** @var TerminalsModel $terminals */
        $terminals = parent::hydrate($data, $object);
        return $terminals;
    }
}
