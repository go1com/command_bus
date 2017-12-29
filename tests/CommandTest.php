<?php
namespace go1\command\tests;

use go1\command\CommandBus;
use go1\command\CommandInterface;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function test()
    {
        $command = $this
            ->getMockBuilder(CommandInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMockForAbstractClass();

        $command
            ->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $commandBus = new CommandBus();
        $commandBus->execute($command);
    }
}
