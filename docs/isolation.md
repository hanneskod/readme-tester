<!--
#[ReadmeTester\Isolate]
-->

# Isolation

Readmetester can use different runners to execute examples. The default runner
executes all examples in isolation. This makes for a solid testing experience,
but is slow..

A faster alternative is the `eval`runner that executed examples by including
them in the current environment. This is much faster, but failes if two examples
define the same symbol. The following is perfectly valid, but will fail using
the eval runner as the context is included in both examples.

#[ReadmeTester\ExampleContext]
```php
function a_function_included_in_all_examples() {}
```

```php
```

```php
```

Here is another example that will fail using the eval runner, as the same symbol
is both in _parent_ and then imported once again into _child_.

#[ReadmeTester\Name('parent')]
```php
function parent_function() {}
```

#[ReadmeTester\Name('child')]
#[ReadmeTester\Import('parent')]
```php
```

Use the `Isolate` attribute to require that an example be executed in isolation.
