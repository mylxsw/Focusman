<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/10
 * Time: 16:19
 */
namespace Focusman\Sae;

trait CacheTrait {

    public function cacheGet($key, $callback = null, $ttl = 0) {
        $cache = DI::getContainer()->get('cache');
        $res = $cache->get($key);
        if ($res != false) {
            return unserialize($res);
        }

        if (is_callable($callback)) {
            $res = $callback();
            if (!empty($res)) {
                $cache->set($key, serialize($res));
            }
        }

        return $res;
    }

    public function cacheDel($key) {
        $cache = DI::getContainer()->get('cache');
        $cache->delete($key);
    }
}