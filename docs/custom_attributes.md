# Custom attributes

Extend readmetester with custom attributes by implementing the
`TransformationInterface` interface.

Here is a completely useless way of replacing the content of a php example:

<!-- <<ReadmeTester\Bootstrap>> -->
```php
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

class HelloWorld implements TransformationInterface
{
    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withCodeBlock(
            new CodeBlock("echo 'hello world';")
        );
    }
}
```

<<HelloWorld>>
<<ReadmeTester\ExpectOutput("hello world")>>
```php
// this example will echo "helo world" as the HelloWorld attribute will replace
// its content...
```
