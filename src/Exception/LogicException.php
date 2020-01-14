<?php

declare(strict_types=1);

namespace PayNL\Sdk\Exception;

use LogicException as SplLogicException;

/**
 * Class LogicException
 *
 * @package PayNL\Sdk\Exception
 */
class LogicException extends SplLogicException implements ExceptionInterface
{
}
