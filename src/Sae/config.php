<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/9
 * Time: 20:33
 */

return [
    'realm'                 => 'webdav',

    'authentication'        => \DI\factory(function() {
       return new \Focusman\Sae\Authentication();
    }),

    // SaeStorage 代理类实现，增加权限检查功能，限制用户权限
    'saeStorage'            => \DI\factory(function(\DI\Container $container) {
        return new \Focusman\Sae\SaeStorageProxy(
            $container->get('_saeStorage'),
            $container->get('authentication')
        );
    }),

    // SaeStorage真实对象，没有权限限制
    '_saeStorage'           => \DI\factory(function() {
        return new \Focusman\Sae\SaeStorage();
    }),

    'cache'                 => \DI\factory(function() {

        $kvdb = new \SaeKV();
        $kvdb->init();

        return $kvdb;
    }),

    'medoo'                 => \DI\factory(function() {
        return new \medoo([
            // required
            'database_type' => 'mysql',
            'database_name' => SAE_MYSQL_DB,
            'server'        => SAE_MYSQL_HOST_M,
            'username'      => SAE_MYSQL_USER,
            'password'      => SAE_MYSQL_PASS,
            'charset'       => 'utf8',

            // optional
            'port'          => SAE_MYSQL_PORT,
            // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
            'option'        => [PDO::ATTR_CASE => PDO::CASE_NATURAL ]
        ]);
    }),
    'userRepo'              => \DI\factory(function() {
        return new \Focusman\Sae\Repo\UserRepo();
    })

];