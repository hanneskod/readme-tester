# Ignoring examples

By default all found php code blocks are tested. There are two ways to ignore
(or skipp) selected examples: ignore individual examples, or ignore all unmarked
examples. Ignored examples are not validated in any way.

## Ignoring individial examples

By using the `Ignore` attribute. Since the following example is ignored the
obious error does not matter.

#[ReadmeTester\Ignore]
```php
this is not a valid php statement
```

## Ignoring all unmarked examples

The second possibility is to use the `IgnoreUnmarkedExamples` attribute: if
applied to an example it will be ignored _unless_ the example is marked using
the `Example` attribute.

As it does not really make sense to apply `IgnoreUnmarkedExamples` to individual
examples (we use the `Ignore` attribute for this), `IgnoreUnmarkedExamples` is
best used as a _global_ attribute.
