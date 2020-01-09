<?php

declare(strict_types=1);

namespace PayNL\Sdk\Util;

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
     * @return string
     */
    public static function getClassNameByFile(string $file): string
    {
        $fp = fopen($file, 'rb');
        $class = $namespace = $buffer = '';
        $i = 0;
        while (!$class) {
            if (feof($fp)) {
                break;
            }

            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) {
                continue;
            }

            $tokenCount = count($tokens);

            for (; $i < $tokenCount; $i++) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j = $i+1; $j < $tokenCount; $j++) {
                        if ($tokens[$j][0] === T_STRING) {
                            $namespace .= '\\'.$tokens[$j][1];
                        } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                            break;
                        }
                    }
                }

                if ($tokens[$i][0] === T_CLASS) {
                    for ($j = $i+1; $j < $tokenCount; $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i+2][1];
                        }
                    }
                }
            }
        }

        return $namespace . '\\' . $class;
    }
}
