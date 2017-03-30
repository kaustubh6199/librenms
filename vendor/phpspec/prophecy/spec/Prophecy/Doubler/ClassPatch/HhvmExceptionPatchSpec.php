<?php

namespace spec\Prophecy\Doubler\ClassPatch;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Doubler\Generator\Node\ClassNode;
use Prophecy\Doubler\Generator\Node\MethodNode;

class HhvmExceptionPatchSpec extends ObjectBehavior
{
    function it_is_a_patch()
    {
        $this->shouldBeAnInstanceOf('Prophecy\Doubler\ClassPatch\ClassPatchInterface');
    }

    function its_priority_is_minus_50()
    {
        $this->getPriority()->shouldReturn(-50);
    }

    function it_uses_parent_code_for_setTraceOptions(ClassNode $node, MethodNode $method, MethodNode $getterMethod)
    {
        $node->hasMethod('setTraceOptions')->willReturn(true);
        $node->getMethod('setTraceOptions')->willReturn($method);
        $node->hasMethod('getTraceOptions')->willReturn(true);
        $node->getMethod('getTraceOptions')->willReturn($getterMethod);

        $method->useParentCode()->shouldBeCalled();
        $getterMethod->useParentCode()->shouldBeCalled();

        $this->apply($node);
    }
}
