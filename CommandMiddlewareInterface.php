<?php

namespace go1\command;

interface CommandMiddlewareInterface
{
    public function invoke(CommandInterface $command);
}
