<?php

declare(strict_types=1);

namespace PayNL\Sdk\Exception;

use DomainException as SplDomainException;

/**
 * Class DomainException
 *
 * @package PayNL\Sdk\Exception
 */
class DomainException extends SplDomainException implements ExceptionInterface
{
}
