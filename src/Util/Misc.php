<?php

declare(strict_types=1);

namespace PayNL\Sdk\Util;

use PayNL\Sdk\Exception\RuntimeException;

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
     * @throws RuntimeException when given file can not be opened
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @return string
     */
    public static function getClassNameByFile(string $file): string
    {
        $handle = fopen($file, 'rb');
        if (false === $handle) {
            throw new RuntimeException(
                sprintf(
                    'Can not open file "%s"',
                    $file
                )
            );
        }

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

        return $namespace . '\\' . $class;
    }
}
