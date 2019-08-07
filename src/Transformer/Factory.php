<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Request;
use PayNL\Sdk\Transformer;
use PayNL\Sdk\Exception;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Transformer
 */
class Factory
{
    /**
     * @param string $requestClass
     *
     * @return TransformerInterface
     */
    public static function factory(string $requestClass): TransformerInterface
    {
        switch ($requestClass) {
            case Request\Currencies\GetAll::class:
            case Request\Currencies\Get::class:
                $transformerClass = Transformer\Currency::class;
                break;
            case Request\Transactions\GetAll::class:
            case Request\Transactions\Get::class:
            case Request\Transactions\Create::class:
                $transformerClass = Transformer\Transaction::class;
                break;
            case Request\Transactions\GetReceipt::class:
                $transformerClass = Transformer\TransactionReceipt::class;
                break;
            default:
                throw new Exception\DomainException(
                    sprintf(
                        'No transformer found for "%s"',
                        $requestClass
                    )
                );
        }

        if (false === class_exists($transformerClass)) {
            throw new Exception\LogicException(
                sprintf(
                    'Missing transformer "%s"',
                    $transformerClass
                )
            );
        }

        return new $transformerClass();
    }
}
