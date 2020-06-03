<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->exclude(array('build', 'vendor','.docker','var'))
    ->files()
    ->name('*.php')
;
return PhpCsFixer\Config::create()
    ->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules(array(
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'align'
        ],
        'combine_consecutive_unsets' => true,
        'native_function_invocation' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => true,
        'phpdoc_summary' => true,
        'strict_comparison' => true,
        'declare_strict_types' => true
    ))
;
