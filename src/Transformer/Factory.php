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
        // TODO create transformer interfaces to recognize the correct transformer instead its based on request class name?
        switch ($requestClass) {
            case Request\Currencies\GetAll::class:
            case Request\Currencies\Get::class:
                $transformerClass = Transformer\Currency::class;
                break;
            case Request\Terminals\Get::class:
                $transformerClass = Transformer\Terminal::class;
                break;
            case Request\Transactions\GetAll::class:
            case Request\Transactions\Get::class:
            case Request\Transactions\Create::class:
            case Request\Transactions\Recurring::class:
                $transformerClass = Transformer\Transaction::class;
                break;
            case Request\Transactions\Refund::class:
                $transformerClass = Transformer\Refund::class;
                break;
            case Request\Transactions\GetReceipt::class:
                $transformerClass = Transformer\Receipt::class;
                break;
            default:
                throw new Exception\DomainException( // TODO errors to separate class?
                    sprintf(
                        'No transformer found for "%s"',
                        $requestClass
                    ),
                    501
                );
        }

        if (false === class_exists($transformerClass)) {
            throw new Exception\LogicException(
                sprintf(
                    'Missing transformer "%s"',
                    $transformerClass
                ),
                501
            );
        }

        return new $transformerClass();
    }
}
