<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineAfterStatementFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\RuleSet\Sets\DoctrineAnnotationSet;
use PhpCsFixer\RuleSet\Sets\PhpCsFixerSet;
use PhpCsFixer\RuleSet\Sets\SymfonySet;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\CyclomaticComplexitySniff;
use SlevomatCodingStandard\Sniffs\Commenting\DisallowCommentAfterCodeSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(DeclareStrictTypesFixer::class);
    $services->set(MultilineWhitespaceBeforeSemicolonsFixer::class);
    $services->set(BlankLineAfterStatementFixer::class);
    $services->set(BlankLineBeforeStatementFixer::class);
    $services->set(SymfonySet::class);
    $services->set(DoctrineAnnotationSet::class);
    $services->set(PhpCsFixerSet::class);
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [
            ['syntax' => 'short',],
        ]);
    
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/config',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '/config/bundles.php',
        PhpUnitTestClassRequiresCoversFixer::class,
        NotOperatorWithSuccessorSpaceFixer::class,
        DisallowCommentAfterCodeSniff::class,
        ExplicitStringVariableFixer::class,
        IsNullFixer::class,
    ]);

    $parameters->set(Option::SETS, [
        SetList::PSR_1,
        SetList::PSR_12,
        SetList::PHP_CS_FIXER,
        SetList::CLEAN_CODE,
        SetList::ARRAY,
        SetList::COMMON,
        SetList::SYMFONY,
        SetList::COMMENTS,
        SetList::SPACES,
        SetList::DOCTRINE_ANNOTATIONS,
    ]);

    $parameters->set(Option::INDENTATION, 'spaces');

    $services->set(CyclomaticComplexitySniff::class)
        ->property('complexity', 13)
        ->property('absoluteComplexity', 13);
};
