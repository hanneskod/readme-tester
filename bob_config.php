<?php

namespace Bob\BuildConfig;

task('default', ['all']);

desc('Build phar');
task('build', ['test'], function () {
    sh('box compile', null, ['failOnError' => true]);
});

desc('Run all targets');
task('all', ['test', 'phpstan', 'sniff', 'build']);

desc('Run unit and feature tests');
task('test', ['phpunit', 'phpspec', 'behat', 'examples']);

desc('Run phpunit tests');
task('phpunit', ['src/Parser/Parser.php'], function() {
    sh('phpunit', null, ['failOnError' => true]);
    println('Phpunit tests passed');
});

desc('Run phpspec tests');
task('phpspec', ['src/Parser/Parser.php'], function() {
    sh('phpspec run', null, ['failOnError' => true]);
    println('Phpspec tests passed');
});

desc('Run behat feature tests');
task('behat', ['src/Parser/Parser.php'], function() {
    sh('behat --stop-on-failure', null, ['failOnError' => true]);
    println('Behat feature tests passed');
});

desc('Test examples');
task('examples', function() {
    sh('bin/readme-tester README.md', null, ['failOnError' => true]);
    println('Examples passed');
});

desc('Run statical analysis using phpstan');
task('phpstan', function() {
    sh('phpstan analyze -c phpstan.neon -l 5 src', null, ['failOnError' => true]);
    println('Phpstan analysis passed');
});

desc('Run php code sniffer');
task('sniff', function() {
    sh('phpcs src --standard=PSR2 --ignore=src/Parser/Parser.php', null, ['failOnError' => true]);
    println('Syntax checker on src/ passed');
});

desc('Build parser');
task('build_parser', ['src/Parser/Parser.php']);

$parserFiles = fileList('*.peg')->in([__DIR__ . '/src/Parser']);

fileTask('src/Parser/Parser.php', $parserFiles, function() {
    sh('phpeg generate src/Parser/Parser.peg', null, ['failOnError' => true]);
    println('Generated parser');
});

desc('Globally install development tools');
task('install_dev_tools', function() {
    sh('composer global require consolidation/cgr', null, ['failOnError' => true]);
    sh('cgr scato/phpeg:^1.0', null, ['failOnError' => true]);
    sh('cgr phpunit/phpunit:^7', null, ['failOnError' => true]);
    sh('cgr phpspec/phpspec:^5.1', null, ['failOnError' => true]);
    sh('cgr behat/behat:^3.3', null, ['failOnError' => true]);
    sh('cgr phpstan/phpstan', null, ['failOnError' => true]);
    sh('cgr squizlabs/php_codesniffer:^3', null, ['failOnError' => true]);
});
