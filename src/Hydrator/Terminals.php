<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\Terminals as TerminalsModel;

/**
 * Class Terminals
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Terminals extends AbstractHydrator
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
                $data['terminals'][$key] = $this->hydratorManager->get('Simple')->hydrate($terminal, $this->modelManager->build('Terminal'));
            }
        }

        /** @var TerminalsModel $terminals */
        $terminals = parent::hydrate($data, $object);
        return $terminals;
    }
}
