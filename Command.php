<?php

namespace go1\command;

class Command implements CommandInterface
{
    private $propagationStopped = false;

    protected $payload;

    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    public function stopPropagation()
    {
        $this->propagationStopped = true;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}

