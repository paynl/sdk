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
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Factory
{
    /**
     * @param string $requestClass
     *
     * @throws Exception\DomainException when no transformer can be found for given request class name
     * @throws Exception\LogicException when the transformer is not implemented
     *
     * @return TransformerInterface
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public static function getByRequestClassName(string $requestClass): TransformerInterface
    {
        if (0 === strpos($requestClass, 'class@anonymous')) {
            // mock test response
            return new Transformer\Simple();
        }

        // TODO create transformer interfaces to recognize the correct transformer instead its based on request class name?
        switch ($requestClass) {
            case Request\Currencies\GetAll::class:
            case Request\Currencies\Get::class:
                $transformerClass = Transformer\Currency::class;
                break;
            case Request\Directdebits\Get::class:
            case Request\Directdebits\Create::class:
            case Request\Directdebits\Update::class:
            case Request\Directdebits\CreateRecurring::class:
                $transformerClass = Transformer\Directdebit::class;
                break;
            case Request\Merchants\Get::class:
            case Request\Merchants\AddTrademark::class:
            case Request\Merchants\DeleteTrademark::class:
                $transformerClass = Transformer\Merchant::class;
                break;
            case Request\Pin\GetTerminals::class:
                $transformerClass = Transformer\Terminal::class;
                break;
            case Request\Pin\GetTerminalTransactionStatus::class:
            case Request\Pin\PayTransaction::class:
                $transformerClass = Transformer\TerminalTransaction::class;
                break;
            case Request\Qr\Decode::class:
                $transformerClass = Transformer\Qr::class;
                break;
            case Request\Refunds\Get::class:
            case Request\Transactions\Refund::class:
                $transformerClass = Transformer\Refund::class;
                break;
            case Request\Services\GetAll::class:
            case Request\Services\Get::class:
                $transformerClass = Transformer\Service::class;
                break;
            case Request\Services\GetPaymentMethods::class:
                $transformerClass = Transformer\PaymentMethod::class;
                break;
            case Request\Transactions\Get::class:
            case Request\Transactions\Create::class:
            case Request\Transactions\Approve::class:
            case Request\Transactions\Capture::class:
            case Request\Transactions\Decline::class:
            case Request\Transactions\QR::class:
            case Request\Transactions\Tokenize::class:
            case Request\Transactions\Cancel::class:
                $transformerClass = Transformer\Transaction::class;
                break;
            case Request\Pin\GetReceipt::class:
                $transformerClass = Transformer\Receipt::class;
                break;
            case Request\Directdebits\Delete::class:
            case Request\IsPay\Get::class:
            case Request\Vouchers\Activate::class:
            case Request\Vouchers\Charge::class:
            case Request\Qr\Validate::class:
            case Request\Transactions\Recurring::class:
                $transformerClass = Transformer\NoContent::class;
                break;
            case Request\Pin\ConfirmTerminalTransaction::class:
            case Request\Qr\Encode::class:
            case Request\Services\CreatePaymentLink::class:
            case Request\Vouchers\Balance::class:
                $transformerClass = Transformer\Simple::class;
                break;
            default:
                throw new Exception\DomainException(
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
