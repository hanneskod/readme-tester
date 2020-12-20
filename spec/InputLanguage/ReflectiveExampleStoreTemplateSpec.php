<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\InputLanguage;

use hanneskod\readmetester\InputLanguage\ReflectiveExampleStoreTemplate;
use hanneskod\readmetester\InputLanguage\ReflectiveExampleStore;
use hanneskod\readmetester\InputLanguage\Definition;
use hanneskod\readmetester\Attribute\NamespaceName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReflectiveExampleStoreTemplateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ReflectiveExampleStoreTemplate::class);
    }

    function it_creates_example_code()
    {
        $this->beConstructedWith(
            [],
            [new Definition(code: "echo 'foobar';")]
        );

        $this->render()->shouldContainExampleWithCode("echo 'foobar';");
    }

    function it_creates_example_attribute()
    {
        $this->beConstructedWith(
            [],
            [new Definition(attributes: [NamespaceName::createAttribute('foo')])]
        );

        $this->render()->shouldContainExampleWithAttribute(new NamespaceName('foo'));
    }

    function it_includes_default_namespace()
    {
        $this->beConstructedWith(
            [],
            [new Definition]
        );

        $this->setDefaultNamespace('bar');

        $this->render()->shouldContainExampleWithAttribute(new NamespaceName('bar'));
    }

    function it_includes_global_attributes()
    {
        $this->beConstructedWith(
            [NamespaceName::createAttribute('baz')],
            [new Definition]
        );

        $this->render()->shouldContainExampleWithAttribute(new NamespaceName('baz'));
    }

    function it_fails_on_invalid_attribute()
    {
        $this->beConstructedWith(
            [],
            [new Definition(attributes: ['this-is-not-a-valid-attribute'])]
        );

        $this->shouldThrow(\RuntimeException::class)->duringRender();
    }

    function getMatchers(): array
    {
        return [
            'containExampleWithCode' => function (ReflectiveExampleStore $store, string $expectedCode) {
                foreach ($store->getExamples() as $example) {
                    if ($example->getCodeBlock()->getCode() == $expectedCode) {
                        return true;
                    }
                }

                return false;
            },
            'containExampleWithAttribute' => function (ReflectiveExampleStore $store, object $expectedAttribute) {
                foreach ($store->getExamples() as $example) {
                    foreach ($example->getAttributes() as $attribute) {
                        if ($attribute == $expectedAttribute) {
                            return true;
                        }
                    }
                }

                return false;
            },
        ];
    }
}
