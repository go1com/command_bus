<?php
namespace go1\command\tests;

use go1\command\CommandHandlerInterface;
use go1\command\CommandInterface;

class CommandFooHandler implements CommandHandlerInterface
{
   public function handle(CommandInterface $command)
   {
       return 'foo.executed';
   }
}
