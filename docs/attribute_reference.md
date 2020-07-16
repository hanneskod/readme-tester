# Attribute reference

## Bootstrap

Load the example into the current environment. Its symbols will be globally
avaliable. Implies ignore.

## Example

Mark example as a readmetester example. Optionally give it a name.

## ExampleContext

Mark example as a context for all examples in the same file.

## ExpectError

Expect that example produces an error. Argument is treated as a regular
expression and is matched against the error output.

## ExpectOutput

Expect that example produces output. Argument is treated as a regular
expression and is matched against the output.

## Ignore

Ignore example, do not evaluate it in any way.

## IgnoreError

Ignore any error produced by example.

## IgnoreOutput

Ignore any output produced by example.

## IgnoreUnmarkedExamples

Ignore example if it is not marked with the `Example` attribute. Usable as a
global attribute.

## Import

Import the contents (prepend) of a named example into the current one.

## Name

Give current example a short name.

## NamespaceName

Give current a namespace name. Namespace defaults to filename.
