<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Validator\ObjectInstance;
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
class TerminalTransaction extends ClassMethods
{
    public function __construct($underscoreSeparatedKeys = true, $methodExistsCheck = false)
    {
        // override the given params
        parent::__construct(false, true);
    }

    /**
     * @inheritDoc
     *
     * @return TerminalTransactionModel
     */
    public function hydrate(array $data, $object): TerminalTransactionModel
    {
        $instanceValidator = new ObjectInstance();
        if (false === $instanceValidator->isValid($object, TerminalTransactionModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

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
