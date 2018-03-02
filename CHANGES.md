# Changes in 1.0-beta4

* `@include` annotation replaces `@extends`.
* Removed `@expectNothing`, `@expectException`, `@expectReturn` and `@expectReturnType` annotations
* Now failes if examples produces outcomes that are not handled
* `--filter` now only works on named examples
* Added the `--flagged-only` option
* Added the `--format` option and the json format
* Added the `--runner` option
* Added the `--ignore-unknown-annotations` option
* Annotation arguments can now be enclosed in single as well as double qoutes
* Included examples are no longer wrapped in output buffering
* Is now a single command application (eg. no `test` argument)
