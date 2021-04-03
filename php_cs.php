<?php

/**
 * @codeCoverageIgnoreStart
 */ 
$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'var',
        'public',
        'vendor',
    ])
    ->in(__DIR__);

$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        '@PhpCsFixer' => true,
        '@DoctrineAnnotation' => true,
        '@Symfony' => true,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'multiline_whitespace_before_semicolons' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
    ])
    ->setFinder($finder);
// @codeCoverageIgnoreEnd
