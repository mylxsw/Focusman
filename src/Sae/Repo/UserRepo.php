<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/10
 * Time: 17:41
 */

namespace Focusman\Sae\Repo;

/**
 * Class UserRepo
 *
 *
CREATE TABLE IF NOT EXISTS `webdav_users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` char(48) NOT NULL,
    `spacelimit` int(11) NOT NULL DEFAULT '209715200',
    `user_status` tinytext NOT NULL,
    `create_time` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
 *
 * @package Focusman\Sae\Repo
 */
class UserRepo extends Repo {

    private $_table = 'webdav_users';

    public function getUser($username) {
        return $this->getConnection()->get($this->_table, '*', [
            'username'  => $username
        ]);
    }
}