# Configuration

ReadmeTester can be configured using yaml configuration files, or using command
line options.

## Yaml configuration

When executed ReadmeTester looks for a configuration file named
`readme-tester.yaml` or `readme-tester.yaml.dist` (in that order) in the current
working directory.

Use the `--config` option to specify a custom configuration file.

A configuration file may look like the following:

```yaml
suites:
    docs:
        include_paths:
            - docs
        stop_on_failure: true
```

Keys are case sensitive.

### Suites

A configuration file may define one or more suites. On invocation each suite
is executed (unless the `--suite` option is used).

> NOTE that examples defined in different suites can not import each other.

In addition a configuration file may include a `defaults` section containing
default settings that will be applied to each suite.

```yaml
defaults:
    # Will be applied to all suites
    stop_on_failure: true

suites:
    first_suite:
        include_paths: [docs]
        exclude_paths: [docs/ignorefile.md]

    second_suite:
        include_paths: [other-path]
```

> NOTE that paths and file extensions are case in-sensitive and relative to
> the current working directory.

See [default_configuration.yaml](../etc/default_configuration.yaml) for a
complete list of possible configurations and their default values.

### Root level configurations

A few configuration directives should be entered at the root level (not in a
`defaults` or `suites` section). Most notably this includes `bootstrap` and
`output_format`.

## Command line options

If specified a command line option overrides configuration file settings and is
applied to each suite.

For a complete list of avaliable options run:

```shell
readme-tester --help
```

### Debugging test cases

The `debug` output format prints extensive information on created examples and
their outcomes. Use togheter with the `--filter` option to only show information
on the example you are debugging:

```shell
readme-tester --output debug --filter my-failing-example
```
