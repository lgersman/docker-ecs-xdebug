<?php


// \spl_autoload_register(function($className)
// {
//   if( str_starts_with($className, 'WordPressCS\\WordPress')) {
//     $file=str_replace('\\','/',$className);
//     $file=str_replace('WordPressCS/', __DIR__ . '/vendor/wp-coding-standards/wpcs/', $file) . '.php';
//     if(file_exists($file)) {
//       require_once($file);
//     }
//   }
// });

use PHP_CodeSniffer\Autoload;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;

$codeSnifferConfig = new PHP_CodeSniffer\Config(["-s", "--no-cache", "--standard=./ruleset.xml"]);
PHP_CodeSniffer\Autoload::addSearchPath(__DIR__ . '/vendor/wp-coding-standards/wpcs/WordPress', "WordPressCS\WordPress");
PHP_CodeSniffer\Autoload::addSearchPath(__DIR__ . '/vendor/wp-coding-standards/wpcs/WordPress-Extra', "WordPressCS\WordPress-Extra");
PHP_CodeSniffer\Autoload::addSearchPath(__DIR__ . '/vendor/wp-coding-standards/wpcs/WordPress-Core', "WordPressCS\WordPress-Core");

$configure = ECSConfig::configure();

$codeSnifferRuleset = new PHP_CodeSniffer\Ruleset($codeSnifferConfig);

return $configure->withRules([
    // our existing PSR12 set from PHP Code Sniffer
    ...array_values($codeSnifferRuleset->sniffCodes),

    // and the two new rules I wanted from PHP CS Fixer
    // PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer::class,
    // PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer::class,
])
  ->withPaths([__DIR__])
  ->withRootFiles()
  ->withSkip(
    [
      '*/vendor/*',
      '*/build/*',
      '*/dist/*',
      '*/node_modules/*',
      '*/languages/*',
      '/phpunit/*',
      '/tmp/*',
      './ecs-config.php',
    ]
  )
  ->withPreparedSets(
    symplify: true,
    psr12: true,
    // arrays: true,
    common: true, // (arrays | spaces | namespaces | docblocks | controlStructures | phpunit | comments)
    cleanCode: true,
    // comments: true,
    // docblocks: true,
    // spaces: true,
    // namespaces : true,
    // controlStructures: true,
    // phpunit : true
    // strict: true,
    // docblocks: true,
  )
  // use 2 spaces instead of psr12 default (4 spaces)
  ->withSpacing(indentation: '  ')

  ->withConfiguredRule(YodaStyleFixer::class, [
    'equal' => true,
    'identical' => true,
    'less_and_greater' => true,
  ])
;
