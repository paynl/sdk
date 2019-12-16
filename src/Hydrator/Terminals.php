<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Terminals as TerminalsModel,
    Model\Terminal as TerminalModel,
    Hydrator\Simple as SimpleHydrator
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

        if (false === array_key_exists('terminals', $data)) {
            // assume data array given are terminals
            $data = [
                'terminals' => $data,
            ];
        }

        foreach ($data['terminals'] as $key => $terminal) {
            if (true === is_array($terminal)) {
                $data['terminals'][$key] = (new SimpleHydrator())->hydrate($terminal, new TerminalModel());
            }
        }

        /** @var TerminalsModel $terminals */
        $terminals = parent::hydrate($data, $object);
        return $terminals;
    }
}
