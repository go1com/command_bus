<?php

namespace go1\command;

use go1\command\tests\CommandFoo;
use go1\command\tests\CommandFooHandler;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function test()
    {
        $commandMiddleware = $this
            ->getMockBuilder(CommandMiddlewareInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['invoke'])
            ->getMockForAbstractClass();

        $commandFoo = new CommandFoo();
        $commandFoo->setPayload('foo');
        $commandFooHandler = new CommandFooHandler();

        $commandMiddleware
            ->expects($this->once())
            ->method('invoke')
            ->willReturnCallback(
                function (CommandInterface $command) {
                    $this->assertEquals('foo', $command->getPayload());

                    return true;
                }
            );

        $commandBus = new CommandBus([$commandFooHandler], [$commandMiddleware]);
        $this->assertEquals('foo.executed', $commandBus->execute($commandFoo));
    }

    public function testPropagation()
    {
        $commandMiddleware = $this
            ->getMockBuilder(CommandMiddlewareInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['invoke'])
            ->getMockForAbstractClass();

        $commandFoo = new CommandFoo();
        $commandFoo->setPayload('foo');
        $commandFooHandler = new CommandFooHandler();

        $commandMiddleware
            ->expects($this->once())
            ->method('invoke')
            ->willReturnCallback(
                function (CommandInterface $command) {
                    $command->stopPropagation();
                }
            );

        $commandBus = new CommandBus([$commandFooHandler], [$commandMiddleware]);
        $this->assertNull($commandBus->execute($commandFoo));
    }
}
