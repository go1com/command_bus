<?php
namespace go1\command\tests;

use go1\command\CommandBus;
use go1\command\CommandInterface;
use PHPUnit\Framework\TestCase;

class CommandHandlerTest extends TestCase
{
    /**
     * @expectedException \go1\command\CommandHandlerNotFoundException
     */
    public function testNotFoundCommandHandler()
    {
        $command = $this
            ->getMockBuilder(CommandInterface::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMockForAbstractClass();

        $commandBus = new CommandBus();
        $commandBus->execute($command);
    }

    public function test()
    {
        $commandFoo = new CommandFoo();
        $commandFooHandler = new CommandFooHandler();

        $commandBus = new CommandBus([$commandFooHandler]);
        $this->assertEquals('foo.executed', $commandBus->execute($commandFoo));
    }
}
