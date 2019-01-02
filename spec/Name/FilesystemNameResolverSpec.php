<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Name;

use hanneskod\readmetester\Name\FilesystemNameResolver;
use hanneskod\readmetester\Name\NameResolverInterface;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemNameResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemNameResolver::CLASS);
    }

    function it_is_a_resolver()
    {
        $this->shouldHaveType(NameResolverInterface::CLASS);
    }

    function it_returns_resolved_paths(NameInterface $baseName, NameInterface $toResolve)
    {
        $toResolve->getShortName()->willReturn('');
        $toResolve->getNamespaceName()->willReturn(__FILE__);
        $this->resolve($baseName, $toResolve)->shouldResolveNamespaceTo(__FILE__);
    }

    function it_returns_expanded_paths(NameInterface $baseName, NameInterface $toResolve)
    {
        $toResolve->getShortName()->willReturn('');
        $toResolve->getNamespaceName()->willReturn(__DIR__ . '/../Name/FilesystemNameResolverSpec.php');
        $this->resolve($baseName, $toResolve)->shouldResolveNamespaceTo(__DIR__ . '/FilesystemNameResolverSpec.php');
    }

    function it_prepends_basepath_if_applicable(NameInterface $baseName, NameInterface $toResolve)
    {
        $toResolve->getShortName()->willReturn('');
        $toResolve->getNamespaceName()->willReturn('FilesystemNameResolverSpec.php');
        $baseName->getNamespaceName()->willReturn(__DIR__ . '/OtherFile.php');
        $this->resolve($baseName, $toResolve)->shouldResolveNamespaceTo(__DIR__ . '/FilesystemNameResolverSpec.php');
    }

    function it_ignores_if_unable_to_resolve(NameInterface $baseName, NameInterface $toResolve)
    {
        $toResolve->getNamespaceName()->willReturn('DOES-NOT-EXIST');
        $baseName->getNamespaceName()->willReturn(__FILE__);
        $this->resolve($baseName, $toResolve)->shouldReturn($toResolve);
    }

    public function getMatchers(): array
    {
        return [
            'resolveNamespaceTo' => function (NameInterface $name, string $namespace) {
                return $name->getNamespaceName() == $namespace;
            },
        ];
    }
}
