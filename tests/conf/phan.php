<?php

/**
 * This is a configuration file for Phan Static Analysis.
 *
 * For setting details see: https://github.com/phan/phan/wiki/Getting-Started#creating-a-config-file
 */

return [
    // A list of directories that should be included during the
    // analysis. Phan does NOT read the auto-loader. Specify the
    // packages that you required in your package.
    'directory_list' => [
        'src',
        'vendor/symfony',
        'vendor/keinos',
    ],
    // A directory list that defines files that will be excluded
    // from static analysis, but whose class and method
    // information should be included.
    'exclude_analysis_directory_list' => [
        'vendor/'
    ],
    // Phan Extension for Symphony Annotation problem.
    // - Ref: https://github.com/phan/phan/issues/1757
    // - Ref: https://github.com/Drenso/PhanExtensions#annotationsymfonyannotationplugin
    'plugins' => [
        'vendor/drenso/phan-extensions/Plugin/Annotation/SymfonyAnnotationPlugin.php',
    ],
];
