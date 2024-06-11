<?php

use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = (new PhpCsFixer\Finder())
    ->in([
        'config',
        'migrations',
        'public',
        'src',
        'tests',
    ])
;

return (new PhpCsFixer\Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'blank_line_after_namespace' => true,
        'declare_strict_types' => true,
        'no_extra_blank_lines' => true,
        'no_unused_imports' => true,
        'ordered_interfaces' => [
            'direction' => 'ascend',
            'order' => 'alpha',
        ],
        'trailing_comma_in_multiline' => true,
        'void_return' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
