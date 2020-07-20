# Constructing examples

## Importing

An example may import the contents of another example using the `Import`
attribute.

<<ReadmeTester\Example('parent')>>
```php
$data = 'parent-data';
```

<<ReadmeTester\Example('child')>>
<<ReadmeTester\Import('parent')>>
<<ReadmeTester\ExpectOutput('parent-data')>>
```php
echo $data;
```

### Chaining imports

TODO
aha,
är det här en bugg?
Det här borde väll implicit betyda att parent också importeras!!

Tillfällig ignore..
<<ReadmeTester\Ignore>>

<<ReadmeTester\Import('child')>>
<<ReadmeTester\ExpectOutput('parent-data')>>
```php
```

### Multiple imports

Works as expected.

<<ReadmeTester\Example('A')>>
```php
$A = 'A';
```
<<ReadmeTester\Example('B')>>
```php
$B = 'B';
```
<<ReadmeTester\Import('A')>>
<<ReadmeTester\Import('B')>>
<<ReadmeTester\ExpectOutput('/AB/')>>
```php
echo $A, $B;
```

## Adding code

You may also prepend or append code to the example using the `PrependCode` and
`AppendCode` attributes.

<<ReadmeTester\PrependCode("echo 'foo ';")>>
<<ReadmeTester\AppendCode("echo ' baz';")>>
<<ReadmeTester\ExpectOutput('foo bar baz')>>
```php
echo "bar";
```
