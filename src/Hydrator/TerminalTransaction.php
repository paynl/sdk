<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Hydrator\Terminal as TerminalHydrator;
use PayNL\Sdk\Model\{
    Progress,
    Terminal,
    TerminalTransaction as TerminalTransactionModel
};

/**
 * Class TerminalTransaction
 *
 * @package PayNL\Sdk\Hydrator
 */
class TerminalTransaction extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return TerminalTransactionModel
     */
    public function hydrate(array $data, $object): TerminalTransactionModel
    {
        $this->validateGivenObject($object, TerminalTransactionModel::class);

        $data['issuerUrl'] = $data['issuerUrl'] ?? '';
        $data['statusUrl'] = $data['statusUrl'] ?? '';
        $data['cancelUrl'] = $data['cancelUrl'] ?? '';
        $data['nextUrl']   = $data['nextUrl'] ?? '';

        if (true === array_key_exists('terminal', $data)) {
            $data['terminal'] = (new TerminalHydrator())->hydrate($data['terminal'], new Terminal());
        }

        if (true === array_key_exists('progress', $data)) {
            $data['progress'] = (new ClassMethods())->hydrate($data['progress'], new Progress());
        }

        /** @var TerminalTransactionModel $terminalTransaction */
        $terminalTransaction = parent::hydrate($data, $object);
        return $terminalTransaction;
    }
}
