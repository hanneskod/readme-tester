<?php

namespace Bob\BuildConfig;

task('default', ['test', 'phpstan', 'sniff']);

desc('Run unit and feature tests');
task('test', ['phpunit', 'behat']);

desc('Run phpunit tests');
task('phpunit', ['src/Parser/Parser.php'], function() {
    sh('phpunit', null, ['failOnError' => true]);
    println('Phpunit tests passed');
});

desc('Run behat feature tests');
task('behat', ['src/Parser/Parser.php'], function() {
    sh('behat --stop-on-failure', null, ['failOnError' => true]);
    println('Behat feature tests passed');
});

desc('Run statical analysis using phpstan');
task('phpstan', function() {
    sh('phpstan analyze -c phpstan.neon -l 7 src', null, ['failOnError' => true]);
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
    sh('vendor/bin/phpeg generate src/Parser/Parser.peg', null, ['failOnError' => true]);
    println('Generated parser');
});
