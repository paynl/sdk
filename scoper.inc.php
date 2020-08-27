<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    'prefix' => 'PayNL',                       // string|null
    'finders' => [
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->notName('/LICENSE|.*\\.md|.*\\.dist|Makefile|Dockerfile|composer\\.json|composer\\.lock/')
            ->exclude([
                'doc',
                'test',
                'test_old',
                'tests',
                'Tests',
                'vendor-bin',
            ])
            ->in('vendor/guzzlehttp'),
    ],                        // Finder[]
    'patchers' => [

    ],                       // callable[]
    'files-whitelist' => [],                // string[]
    'whitelist' => [
        'Psr\*',
    ],                      // string[]
    'whitelist-global-constants' => true,   // bool
    'whitelist-global-classes' => true,     // bool
    'whitelist-global-functions' => true,   // bool
];
