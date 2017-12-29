<?php

namespace go1\command;

use ReflectionClass;
class CommandBus
{
    /**
     * @var CommandMiddlewareInterface[]
     */
    private $middleware;

    /**
     * @var CommandHandlerInterface[]
     */
    private $handlers;

    public function __construct(array $handlers = [], array $middleware = [])
    {
        $this->middleware = $middleware;
        $this->handlers = $handlers;
    }

    private function handler(CommandInterface $command): CommandHandlerInterface
    {
        $handlerName = (new ReflectionClass(get_class($command)))->getShortName() . 'Handler';
        foreach ($this->handlers as $handler) {
            if ((new ReflectionClass(get_class($handler)))->getShortName() == $handlerName) {
                return $handler;
            }
        }

        throw new CommandHandlerNotFoundException('Handler does not exist');
    }

    public function execute(CommandInterface $command)
    {
        foreach ($this->middleware as $middleware) {
            $middleware->invoke($command);
            if ($command->isPropagationStopped()) {
                return null;
            }
        }

        return method_exists($command, 'execute')
            ? $command->execute()
            : $this->handler($command)->handle($command);
    }
}
