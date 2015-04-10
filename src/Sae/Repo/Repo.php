<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/10
 * Time: 17:41
 */

namespace Focusman\Sae\Repo;


use Focusman\Sae\DI;

abstract class Repo {
    /**
     * @return \medoo
     * @throws \DI\NotFoundException
     */
    protected function getConnection() {
        return DI::getContainer()->get('medoo');
    }
} 