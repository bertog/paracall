<?php

namespace spec\Paracall\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Paracall\Console\Generator');
    }
}
