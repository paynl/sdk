<?php

declare(strict_types=1);

namespace PayNL\Sdk\Exception;

use Psr\Container\ContainerExceptionInterface;

/**
 * Class ServiceNotCreatedException
 *
 * @package PayNL\Sdk\Exception
 */
class ServiceNotCreatedException extends RuntimeException implements ContainerExceptionInterface
{
}
