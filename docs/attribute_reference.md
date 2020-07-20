# Attribute reference

## AppendCode

Append code to the current example.

## Assert

Add a custom assertion to the end of the example.

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

## Isolate

Require that the example be executed in isolation.

## Name

Give current example a short name.

## NamespaceName

Give current a namespace name. Namespace defaults to filename.

## PrependCode

Prepend code to the current example.

## StartInHtmlMode

Start example in html mode instead of the default php mode.
