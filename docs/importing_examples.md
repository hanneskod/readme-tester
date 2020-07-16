# Importing examples

An example may import the contents of another example using the `Import`
attribute.

<<ReadmeTester\Example('parent')>>
```php
$data = 'parent-data';
```

<<ReadmeTester\Example('echo-parent-content')>>
<<ReadmeTester\Import('parent')>>
<<ReadmeTester\ExpectOutput('parent-data')>>
```php
echo $data;
```

## Chaining imports

TODO
aha,
är det här en bugg?
Det här borde väll implicit betyda att parent också importeras!!

Tillfällig ignore..
<<ReadmeTester\Ignore>>

<<ReadmeTester\Import('echo-parent-content')>>
<<ReadmeTester\ExpectOutput('parent-data')>>
```php
```

## Importing multiple examples

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
