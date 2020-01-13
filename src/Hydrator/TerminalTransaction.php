<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Progress as ProgressModel,
    Model\Terminal as TerminalModel,
    Model\TerminalTransaction as TerminalTransactionModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class TerminalTransaction
 *
 * @package PayNL\Sdk\Hydrator
 */
class _TerminalTransaction extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return TerminalTransactionModel
     */
    public function hydrate(array $data, $object): TerminalTransactionModel
    {
        $this->validateGivenObject($object, TerminalTransactionModel::class);

        if (true === array_key_exists('terminal', $data) && true === is_array($data['terminal'])) {
            $data['terminal'] = (new SimpleHydrator())->hydrate($data['terminal'], new TerminalModel());
        }

        if (true === array_key_exists('progress', $data) && true === is_array($data['progress'])) {
            $data['progress'] = (new SimpleHydrator())->hydrate($data['progress'], new ProgressModel());
        }

        /** @var TerminalTransactionModel $terminalTransaction */
        $terminalTransaction = parent::hydrate($data, $object);
        return $terminalTransaction;
    }
}
