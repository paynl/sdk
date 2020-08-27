<?php

declare(strict_types=1);

namespace PayNL\Sdk\Exception;

use InvalidArgumentException as SplInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @package PayNL\Sdk\Exception
 */
class InvalidArgumentException extends SplInvalidArgumentException implements ExceptionInterface
{
}
