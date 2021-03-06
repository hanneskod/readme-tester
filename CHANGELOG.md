# Change Log

All notable changes to this project will be documented in this file.
This project now adheres to [Semantic Versioning](http://semver.org/).

## [2.0.0-beta1] - 2020-12-25

Version 2 is a complete rewrite using php8 attributes instead of docblock style
annotation. Major changes include:

- Removed built in phpunit integration
- Removed the `--named-only` command line option
- Removed the `--ignore-unknown-annotations` command line option
- Added the `--file-extension` command line option
- Added the `--exclude` command line option
- Added the `--stop-on-failure` command line option
- Added the `--input` command line option
- Renamed command line option `--format` > `--output`
- Added the `--debug` command line option
- Added support for config files
- Added the `--config` and `--no-config` command line options
- Use a propper event dispatcher
- Added multiple new attributes, se [docs/attribute_reference.md](docs/attribute_reference.md)

## [1.0.0] - 2020-07-06

- Initial release
