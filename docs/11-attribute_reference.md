# Attribute reference

## AppendCode

Append code to the current example.

## Assert

Add a custom assertion to the end of the example.

## DeclareDirective

Prepend a `declare()` directive.

## DeclareStrictTypes

Prepend a `declare(strict_types=1)` directive.

## Example

Mark example as a readmetester example. Optionally give it a name.

## ExampleContext

Mark example as a context for all examples in the same file.

## ExpectError

Expect that example produces an error. Argument is treated as a regular
expression and is matched against the error output.

## ExpectNothing

Expect that no error and no output is generated.

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

## StartInPhpNamespace

Set an initial namespace declaration.

## UseClass

Import a class to the current namespace. Takes the name of the symbol and an
optional local name as arguments (`use [name] as [local-name];`).

## UseConst

Import a constant to the current namespace. Takes the name of the symbol and an
optional local name as arguments (`use const [name] as [local-name];`).

## UseFunction

Import a function to the current namespace. Takes the name of the symbol and an
optional local name as arguments (`use function [name] as [local-name];`).
