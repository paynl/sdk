<?php

declare(strict_types=1);

namespace PayNL\Sdk\Util;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\LogicException;

/**
 * Class Misc
 *
 * @package PayNL\Sdk\Util
 */
class Misc
{
    /**
     * @param string $file
     *
     * @throws InvalidArgumentException when given file can not be found or read
     * @throws LogicException when the class name is not the same as the terminating class file name
     *  (PSR-4 3.3 - https://www.php-fig.org/psr/psr-4/)
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @return string
     */
    public static function getClassNameByFile(string $file): string
    {
        if (false === file_exists($file) || false === is_readable($file)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class can not be found because file "%s" does not exist or can not be read',
                    $file
                )
            );
        }

        $handle = fopen($file, 'rb');

        $class = $namespace = $buffer = '';
        $counter = 0;
        while (!$class) {
            if (feof($handle)) {
                break;
            }

            $buffer .= fread($handle, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) {
                continue;
            }

            $tokenCount = count($tokens);

            for (; $counter < $tokenCount; $counter++) {
                if ($tokens[$counter][0] === T_NAMESPACE) {
                    for ($nextCounter = $counter+1; $nextCounter < $tokenCount; $nextCounter++) {
                        if ($tokens[$nextCounter][0] === T_STRING) {
                            $namespace .= '\\'.$tokens[$nextCounter][1];
                        } else if ($tokens[$nextCounter] === '{' || $tokens[$nextCounter] === ';') {
                            break;
                        }
                    }
                }

                if ($tokens[$counter][0] === T_CLASS) {
                    for ($nextCounter = $counter+1; $nextCounter < $tokenCount; $nextCounter++) {
                        if ($tokens[$nextCounter] === '{') {
                            $class = $tokens[$counter+2][1];
                        }
                    }
                }
            }
        }

        $filename = substr(basename($file), 0, strpos(basename($file), '.'));
        if ($filename !== $class) {
            throw new LogicException(
                sprintf(
                    'Class name "%s" is not the same as the terminating class file name "%s"',
                    $class,
                    $filename
                )
            );
        }

        return $namespace . '\\' . $class;
    }

    /**
     * @param string $fqn
     *
     * @return string
     */
    public static function getClassNameByFQN(string $fqn): string
    {
        $namespaceSeparator = '\\';
        $parts = explode($namespaceSeparator, $fqn);
        return array_pop($parts);
    }
}
