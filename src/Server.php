<?php

namespace Focusman;

abstract class Server
{
    abstract public function run();

    public function start() 
    {
        $this->run();
    }
}
