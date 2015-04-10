<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/10
 * Time: 16:32
 */

namespace Focusman\Sae;


class Tools {

    public static function getUserTotalSpaceKey($username) {
        return "{$username}:total_space";
    }

    public static function getUserListByPathKey($username, $path) {
        return "{$username}:path_list:{$path}";
    }

    public static function getUserListKey($username, $path) {
        return "{$username}:list:{$path}";
    }
} 