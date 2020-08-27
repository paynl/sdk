<?php

/**
 * Attempts to load Composer's autoload.php as either a dependency or a
 * stand-alone package.
 *
 * @return boolean
 */
return static function () {
    // "get" the autoloader file(s), composer dependency and then check for stand-alone
    $files = [
        __DIR__ . '/../../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
    ];
    foreach ($files as $file) {
        if (true === is_file($file)) {
            require_once $file;
            return true;
        }
    }
    return false;
};
