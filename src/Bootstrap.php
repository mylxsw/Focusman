<?php

namespace Focusman;

use Focusman\Sae\SaeServer;

require __DIR__ . '/autoload.php';

class Bootstrap
{
    public static function newServer()
    {
        return new SaeServer();
    }
}
