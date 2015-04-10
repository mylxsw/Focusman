<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/9
 * Time: 14:31
 */

namespace Focusman\Sae;


use Focusman\Server;
use Sabre\DAV;

/**
 * Class SaeServer
 * @package Focusman\Sae
 */
class SaeServer extends Server {


    public function run() {
        $server = new DAV\Server(new HomeCollection());

        $server->addPlugin(new DAV\Browser\Plugin());
        $server->addPlugin(new DAV\Sync\Plugin());

        $authPlugin = new DAV\Auth\Plugin(
            DI::getContainer()->get('authentication'),
            DI::getContainer()->get('realm')
        );
        $server->addPlugin($authPlugin);

        $server->setBaseUri('/');
        $server->exec();
    }
}