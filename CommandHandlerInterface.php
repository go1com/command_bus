<?php
namespace go1\command;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command);
}
