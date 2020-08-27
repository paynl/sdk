<?php

declare(strict_types=1);

namespace PayNL\Sdk\Exception;

use UnexpectedValueException as SplUnexpectedValueException;

/**
 * Class UnexpectedValueException
 *
 * @package PayNL\Sdk\Exception
 */
class UnexpectedValueException extends SplUnexpectedValueException implements ExceptionInterface
{
}
