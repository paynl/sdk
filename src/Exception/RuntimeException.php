<?php

declare(strict_types=1);

namespace PayNL\Sdk\Exception;

use RuntimeException as SplRuntimeException;

/**
 * Class RuntimeException
 *
 * @package PayNL\Sdk\Exception
 */
class RuntimeException extends SplRuntimeException implements ExceptionInterface
{
}
