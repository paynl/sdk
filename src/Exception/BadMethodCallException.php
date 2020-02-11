<?php

declare(strict_types=1);

namespace PayNL\Sdk\Exception;

use BadMethodCallException as SplBadMethodCallException;

/**
 * Class BadMethodCallException
 *
 * @package PayNL\Sdk\Exception
 */
class BadMethodCallException extends SplBadMethodCallException implements ExceptionInterface
{
}
